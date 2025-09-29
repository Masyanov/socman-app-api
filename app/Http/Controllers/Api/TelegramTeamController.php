<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;

class TelegramTeamController extends Controller {
    public function getMyTeams( $user_id ) {
        $teamActive = Team::query()
                          ->where( 'active', true )
                          ->where( 'user_id', $user_id )
                          ->get( [ 'id', 'user_id', 'name', 'team_code' ] );

        return response()->json( [
            'teamActive' => $teamActive
        ] );
    }

    public function playersWhoRespondedToday($team_code)
    {
        $today = Carbon::today();

        // Все игроки команды с telegram_id
        $allPlayers = User::query()
                          ->with('telegramId:id,user_id,telegram_id')
                          ->where('team_code', $team_code)
                          ->get(['id', 'last_name']);

        // Не ответили по восстановлению
        $respondedRecovery = User::query()
                                 ->with('telegramId:id,user_id,telegram_id')
                                 ->where('team_code', $team_code)
                                 ->whereDoesntHave('questions', function ($q) use ($today) {
                                     $q->whereDate('created_at', $today)
                                       ->whereNotNull('recovery'); // answered recovery
                                 })
                                 ->get(['id', 'last_name'])
                                 ->map(function ($user) {
                                     return [
                                         'id'          => $user->id,
                                         'last_name'   => $user->last_name,
                                         'telegram_id' => $user->telegramId->telegram_id ?? null,
                                     ];
                                 })
                                 ->values();

        // Не ответили по нагрузке
        $respondedLoad = User::query()
                             ->with('telegramId:id,user_id,telegram_id')
                             ->where('team_code', $team_code)
                             ->whereDoesntHave('questions', function ($q) use ($today) {
                                 $q->whereDate('created_at', $today)
                                   ->whereNotNull('load'); // answered load
                             })
                             ->get(['id', 'last_name'])
                             ->map(function ($user) {
                                 return [
                                     'id'          => $user->id,
                                     'last_name'   => $user->last_name,
                                     'telegram_id' => $user->telegramId->telegram_id ?? null,
                                 ];
                             })
                             ->values();

        // notResponded — объединение двух списков, уникально по ID
        $notResponded = collect($respondedRecovery)
            ->merge($respondedLoad)
            ->unique('id')
            ->values();

        return response()->json([
            'respondedRecovery' => $respondedRecovery,
            'respondedLoad'     => $respondedLoad,
            'notResponded'      => $notResponded,
        ]);
    }

}
