<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SelectDateController extends Controller
{
    public function getAnswers(Request $request)
    {
        $userId = Auth::user()->id;

        // Получаем команду пользователя
        $team = Team::where('user_id', $userId)->first();

        // Получаем даты из запроса
        $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate)->endOfDay();

        // Получаем ответы на вопросы в заданном диапазоне
        $answers = DB::table('questions')
                     ->select('user_id', 'created_at', 'recovery', 'load')
                     ->whereBetween('created_at', [$startDate, $endDate])
                     ->get();

        // Получаем всех пользователей команды
        $usersOfTeam = User::where('team_code', $team->team_code)->get();

        // Получаем уникальные даты
        $dates = DB::table('questions')
                   ->selectRaw('DATE(created_at) as date')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->distinct()
                   ->pluck('date')
                   ->sort();

        // Формируем структуру данных
        $results = [];

        foreach ($usersOfTeam as $user) {
            $userAnswers = $answers->where('user_id', $user->id);
            $userRow = [];

            foreach ($dates as $date) {
                $recovery = $userAnswers->filter(function ($item) use ($date) {
                    return date('Y-m-d', strtotime($item->created_at)) === $date;
                })->pluck('recovery')->first() ?? '';

                $load = $userAnswers->filter(function ($item) use ($date) {
                    return date('Y-m-d', strtotime($item->created_at)) === $date;
                })->pluck('load')->first() ?? '';

                $userRow[$date] = [
                    'recovery' => (int) $recovery * 10,
                    'load' => (int) $load * 10
                ];
            }

            $results[$user->id] = $userRow;
        }

        return response()->json($results);
    }
}
