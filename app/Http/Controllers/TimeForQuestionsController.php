<?php

namespace App\Http\Controllers;

use App\Models\SettingLoadcontrol;
use App\Models\Team;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Question;

class TimeForQuestionsController extends Controller {
    public function index() {
        $user            = Auth::user();
        $team            = Team::where( 'team_code', $user->team_code )->first();
        $adminId         = $team->user_id;
        $settings        = SettingLoadControl::where( 'user_id', $adminId )->first();
        $timeoutRecovery = $settings->question_recovery_min ?? 60;
        $timeoutLoad     = $settings->question_load_min ?? 60;

        $todayStart = Carbon::today();
        $todayEnd   = Carbon::tomorrow()->subSecond();

        $trainingsToday = Training::where( 'team_code', $user->team_code )
                                  ->where( 'active', true )
                                  ->whereDate( 'date', $todayStart )
                                  ->orderBy( 'start', 'asc' )
                                  ->get();

        $hasAnswerToday = Question::where( 'user_id', $user->id )
                                  ->whereDate( 'created_at', $todayStart )
                                  ->exists();

        if ( $trainingsToday->isNotEmpty() ) {
            $firstTrainingStart = $trainingsToday->first()->start;
            $lastTrainingEnd    = $trainingsToday->last()->finish;

            // В респонс добавляем поле res
            $todayTrainingsStartFinish = [
                'hasAnswerToday'        => $hasAnswerToday,
                'res'                   => true,
                'start'                 => $firstTrainingStart,
                'finish'                => $lastTrainingEnd,
                'question_recovery_min' => $timeoutRecovery,
                'question_load_min'     => $timeoutLoad
            ];
        } else {
            // Нет тренировок
            $todayTrainingsStartFinish = [
                'res' => false
            ];
        }

        return response()->json( $todayTrainingsStartFinish );
    }

}
