<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxFilterCharsController extends Controller {
    public function ajaxCharsFilter( Request $request, Team $team ) {
        // Количество недель назад (например, 52 — это год)
        $weeksCount = 52;
        $weeks      = [];
        $start      = Carbon::now()->startOfWeek( Carbon::MONDAY );

// Предполагаем, что в таблице 'questions' есть поле 'created_at' с датой создания записи
        for ( $i = 0; $i < $weeksCount; $i ++ ) {
            $weekStart = $start->copy()->subWeeks( $i ); // Начало недели (понедельник)
            $weekEnd   = $weekStart->copy()->endOfWeek( Carbon::SUNDAY ); // Конец недели (воскресенье)

            // Проверяем наличие данных в базе за этот период
            $count = DB::table( 'questions' )
                       ->where( 'team_code', $team->team_code )
                       ->whereBetween( 'created_at', [ $weekStart->toDateString(), $weekEnd->toDateString() ] )
                       ->count();

            if ( $count > 0 ) {
                $year    = $weekStart->format( 'Y' );
                $weekNum = $weekStart->format( 'W' ); // ISO-номер недели

                // Формируем значение и отображаемый текст
                $weeks[] = [
                    'value' => "{$year}-W{$weekNum}",
                    'label' => "{$weekStart->format('d.m.Y')} - {$weekEnd->format('d.m.Y')}",
                ];
            }
        }

        // Определяем player_id
        if ( $request->input( 'week' ) ) {
            $weekInput = $request->input( 'week' );
        } elseif ( $request->cookie( 'week' ) ) {
            $weekInput = $request->cookie( 'week' );
        } elseif ( $request->cookies->get( 'week' ) ) {
            $weekInput = $request->cookies->get( 'week' );
        } elseif ( isset( $_COOKIE['week'] ) ) {
            $weekInput = $_COOKIE['week'];
        } else {
            $weekInput = $weeks[0]['value'];
        }
        // Парсим год и номер недели
        if ( preg_match( '/(\d{4})-W(\d{2})/', $weekInput, $matches ) ) {
            $year = $matches[1];
            $week = $matches[2];

            // Получаем понедельник этой недели
            $startOfWeek    = Carbon::now()->setISODate( $year, $week )->startOfWeek( Carbon::MONDAY );
            $datesForSelect = [];
            // Формируем массив дат недели (с понедельника по воскресенье)
            for ( $i = 0; $i < 7; $i ++ ) {
                $datesForSelect[] = $startOfWeek->copy()->addDays( $i )->toDateString();
            }

        } else {
            $datesForSelect = [];
        }

        $team_code = $team->team_code;

        // Получаем записи только с нужным team_code и датой (created_at) из массива дат:
        $records = DB::table('questions')
                     ->join('users', 'questions.user_id', '=', 'users.id') // соединяем с users
                     ->where('questions.team_code', $team_code)
                     ->where('users.active', 1) // только активные пользователи
                     ->whereIn(DB::raw('DATE(questions.created_at)'), $datesForSelect)
                     ->select(
                         DB::raw('DATE(questions.created_at) as created_at'),
                         'questions.recovery',
                         'questions.load'
                     )
                     ->get();


        $recoveryAverages = [];
        $loadAverages     = [];



// Преобразуем коллекцию к удобному формату:
        $grouped = $records->groupBy( 'created_at' );

        foreach ( $datesForSelect as $date ) {
            if ( $grouped->has( $date ) ) {
                $group       = $grouped[ $date ];
                $avgRecovery = round( $group->avg( 'recovery' ), 2 );
                $avgLoad     = round( $group->avg( 'load' ), 2 );
            } else {
                $avgRecovery = null;
                $avgLoad     = null;
            }
            $recoveryAverages[] = $avgRecovery;
            $loadAverages[]     = $avgLoad;


        }

        $resultsCycle = [
            'labels'   => [ 'MD-7', 'MD-6', 'MD-5', 'MD-4', 'MD-3', 'MD-2', 'MD-1' ],
            'dates'    => $datesForSelect,
            'load'     => $loadAverages,
            'recovery' => $recoveryAverages,
        ];

        $teamChars = 2;

        return view( 'partials.data_charts', compact( 'resultsCycle', 'teamChars' ) )->render();
    }
}
