<?php

use App\Models\ClassTraining;
use App\Models\PlayerTest;
use App\Models\PresenceTraining;
use App\Models\Question;
use App\Models\SettingLoadcontrol;
use App\Models\Subscription;
use App\Models\Team;
use App\Models\Training;
use App\Models\AddressesTraining;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if ( ! function_exists( 'CountTeam' ) ) {

    function CountTeam() {
        $userId = Auth::user()->id;
        $user   = User::find( $userId );

        if ( $user->teams()->where( 'active', true )->count() ) {
            return $user->teams()->where( 'active', true )->count();
        } else {
            return $user->teams()->where( 'active', true )->count();
        }
    }
}

function nameLastname( $id ) {
    $user = User::where( 'id', $id )->first();
    if ( isset( $user->last_name ) ) {
        $last_name = $user->last_name;
    } else {
        $last_name = '';
    }
    if ( isset( $user->name ) ) {
        $name = $user->name;
    } else {
        $name = '';
    }

    $fullName = $last_name . ' ' . $name;

    return $fullName;
}

function nameLastnameBreak( $id ) {
    $user = User::where( 'id', $id )->first();

    echo '<div class="w-20">' . $user->last_name . '<br>' . $user->name . '</div>';
}

function playerPosition( $id ) {
    $user = User::where( 'id', $id )->first();

    if ( isset( $user->meta->position ) ) {
        $position = $user->meta->position;
    } else {
        $position = '';
    }

    return $position;
}

function whatInArray( $value ) {
    $countArray = 0;
    foreach ( $value as $v ) {
        $countArray ++;
    }
    if ( $countArray < 1 ) {
        return false;
    } else {
        return true;
    }
}

function countPlayers( $team_code ) {
    $usersOfTeamCount = User::query()
                            ->where( 'active', true )
                            ->where( 'team_code', $team_code )
                            ->latest( 'created_at' )
                            ->count();

    if ( isset( $usersOfTeamCount ) ) {
        return $usersOfTeamCount;
    } else {
        return 'Неизвестно';
    }
}

function countNoActivePlayers( $team_code ) {
    $usersOfTeamCount = User::query()
                            ->where( 'active', false )
                            ->where( 'team_code', $team_code )
                            ->latest( 'created_at' )
                            ->count();
    if ( isset( $usersOfTeamCount ) ) {
        return $usersOfTeamCount;
    } else {
        return 'Неизвестно';
    }
}

function CountPlayerOfCoach() {
    $userId = Auth::user()->id;

    $teamActive = Team::query()
                      ->where( 'active', true )
                      ->where( 'user_id', $userId )
                      ->paginate( 10 );

    $count = [];
    foreach ( $teamActive as $team ) {
        $count[] = countPlayers( $team->team_code );
    }

    if ( isset( $count ) ) {
        return array_sum( $count );
    } else {
        return 'НЕТ';
    }
}

function yourTeam() {
    $teamCode = Auth::user()->team_code;
    $yourTeam = Team::where( 'team_code', $teamCode )->first();

    if ( isset( $yourTeam ) ) {
        echo $result = $yourTeam->name;
    } else {
        echo $result = '<div id="toast-danger" class="flex items-center w-full p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-700" role="alert">
                            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                                </svg>
                                <span class="sr-only">Error icon</span>
                            </div>
                            <div class="ms-3 text-sm font-normal">Ваша команда с кодом <strong>' . $teamCode . '</strong> неизвестна. Видимо у вас не верный код команды. Напишите своему тренеру чтобы исправить ошибку</div>
                            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-danger" aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>';
    }
}

function playerTeam( $team_code ) {
    $yourTeam = Team::where( 'team_code', $team_code )->first();

    if ( isset( $yourTeam ) ) {
        return $yourTeam->name;
    } else {
        return 'Неизвестна. Видимо у вас не верный код команды. Напишите своему тренеру чтобы исправить ошибку';
    }
}

function CountPlaerOfTeam( $team_code ) {
    $usersOfTeam = User::query()
                       ->where( 'team_code', $team_code )
                       ->latest( 'created_at' )
                       ->paginate( 1000 );

    if ( isset( $usersOfTeam ) ) {
        return $usersOfTeam;
    } else {
        return 'НЕТ';
    }
}

function PlayerOfTeam( $team_code ) {
    $usersOfTeam = User::query()
                       ->where( 'team_code', $team_code )
                       ->where( 'active', true )
                       ->latest( 'created_at' )
                       ->paginate( 1000 );

    if ( isset( $usersOfTeam ) ) {
        return $usersOfTeam;
    } else {
        return 'НЕТ';
    }
}

function pluralTeam( $number ) {
    if ( $number % 10 == 1 && $number % 100 != 11 ) {
        return __( 'messages.команда' );
    } else {
        if ( $number % 10 >= 2 && $number % 10 <= 4 && ( $number % 100 < 10 || $number % 100 >= 20 ) ) {
            return __( 'messages.команды' );
        } else {
            return __( 'messages.команд' );
        }
    }
}

function pluralPlayers( $number ) {
    if ( $number % 10 == 1 && $number % 100 != 11 ) {
        return __( 'messages.игрок' );
    } else {
        if ( $number % 10 >= 2 && $number % 10 <= 4 && ( $number % 100 < 10 || $number % 100 >= 20 ) ) {
            return __( 'messages.игрока' );
        } else {
            return __( 'messages.игроков' );
        }
    }
}

function pluralTrainings( $number ) {
    if ( $number % 10 == 1 && $number % 100 != 11 ) {
        return __( 'messages.тренировка' );
    } else {
        if ( $number % 10 >= 2 && $number % 10 <= 4 && ( $number % 100 < 10 || $number % 100 >= 20 ) ) {
            return __( 'messages.тренировки' );
        } else {
            return __( 'messages.тренировок' );
        }
    }
}

function dayOfDate( $date ) {
    $days = [ 'ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ' ];
    $day  = $days[ date( "w", strtotime( $date ) ) ];

    return $day;
}

function nameClass( $id ) {
    $nameClass = ClassTraining::where( 'id', $id )->first();

    if ( isset( $nameClass ) ) {
        $nameClass = $nameClass->name;
    } else {
        $nameClass = 'Без классификации';
    }

    return $nameClass;
}
function nameAddress( $id ) {
    $nameAddress = AddressesTraining::where( 'id', $id )->first();

    if ( isset( $nameAddress ) ) {
        $nameAddress = $nameAddress->name;
    } else {
        $nameAddress = 'Без адреса';
    }

    return $nameAddress;
}

function dateFormatYMD( $value ) {
    return \Carbon\Carbon::parse( $value )->format( 'Y-m-d' );
}

function dateFormatDM( $value ) {
    return \Carbon\Carbon::parse( $value )->format( 'd.m' );
}

function timeFormatHI( $value ) {
    return \Carbon\Carbon::createFromFormat( 'H:i:s', $value )->format( 'H:i' );
}


function timeTo( $start, $finish ) {
    $s = strtotime( $start );
    $f = strtotime( $finish );
    $i = ( $f - $s );

    return ceil( $i / 60 );
}

function trainingToday() {
    $userId = Auth::user()->id;
    $today  = date( 'Y-m-d' );
    $find   = Training::where( 'user_id', $userId )->where( 'date', $today )->first();

    if ( isset( $find ) ) {
        $value = true;
    } else {
        $value = false;
    }

    return $value;
}

function trainingTodayForPlayer() {
    $teamCode = Auth::user()->team_code;
    $today    = date( 'Y-m-d' );
    $find     = Training::where( 'team_code', $teamCode )->where( 'date', $today )->first();

    if ( isset( $find ) ) {
        $value = true;
    } else {
        $value = false;
    }

    return $value;
}

function presenceOfTraining( $id ) {
    $presence = PresenceTraining::query()
                                ->where( 'training_id', $id )
                                ->latest( 'created_at' )
                                ->paginate( 1000 );

    if ( isset( $presence ) ) {
        $value = $presence;
    } else {
        $value = false;
    }

    return $value;

}

function presence( $id ) {
    $presence = PresenceTraining::query()
                                ->where( 'training_id', $id )
                                ->latest( 'created_at' )
                                ->count();

    $find = Training::where( 'id', $id )->first();

    if ( $find ) {
        $countPlayers = $find->count_players;

        $percent = ( $presence / $countPlayers ) * 100;

        return round( $percent, 0 ) . '% (' . $presence . '/' . $countPlayers . ')';
    } else {
        return '0';
    }

}

function presenceAll() {
    $userId = Auth::user()->id;

    $trainings = Training::query()
                         ->where( 'user_id', $userId )
                         ->where( 'active', true )
                         ->where( 'confirmed', true )
                         ->latest( 'created_at' )
                         ->paginate( 10000 );

    if ( whatInArray( $trainings ) ) {

        $allTrainingValues = [];
        foreach ( $trainings as $training ) {
            $presence = PresenceTraining::query()
                                        ->where( 'training_id', $training->id )
                                        ->latest( 'created_at' )
                                        ->count();

            $countPlayers = $training->count_players;
            $percent      = ( $presence / $countPlayers ) * 100;
            array_push( $allTrainingValues, $percent );

        }

        $valueAllTrainings = round( array_sum( $allTrainingValues ) / count( $allTrainingValues ), 0 );
        $value             = $valueAllTrainings;

        return $value;
    }

    return 0;
}

function presenceCheck( $id ) {
    $presence = PresenceTraining::query()
                                ->where( 'training_id', $id )
                                ->latest( 'created_at' )
                                ->count();

    return $presence;
}


function freeNumber( $team_code ) {
    $numbers = [];
    for ( $i = 0; $i <= 98; $i ++ ) {
        $numbers[] = $i + 1;
    }

    $usersOfTeam = User::query()
                       ->where( 'team_code', $team_code )
                       ->latest( 'created_at' )
                       ->paginate( 1000 );

    $playerNumber = [];
    foreach ( $usersOfTeam as $player ) {
        if ( $player->meta && $player->meta->number != null ) { // Check meta exists
            array_push( $playerNumber, $player->meta->number );
        }
    }

    $freeNumber = [];
    foreach ( $numbers as $number ) {
        if ( ! in_array( $number, $playerNumber ) ) {
            array_push( $freeNumber, $number );
        }
    }

    return $freeNumber;

}

function allTrainingCount() {
    $userId    = Auth::user()->id;
    $trainings = Training::query()
                         ->where( 'user_id', $userId )
                         ->where( 'active', true )
                         ->where( 'confirmed', true )
                         ->latest( 'created_at' )
                         ->count();

    return $trainings;
}

function checkLoadControl() {
    if ( Auth::user()->load_control == '1' ) {
        $status = true;
    } else {
        $status = false;
    }

    return $status;
}

function checkLoadControlForPlayer() {
    $team_code = Auth::user()->team_code;
    $coachId   = Team::where( 'team_code', $team_code )->first()->user_id;

    $loadSetting = SettingLoadcontrol::where( 'user_id', $coachId )->first()->on_load;

    return $loadSetting;
}

function checkExtraLoadControlForPlayer() {
    $team_code = Auth::user()->team_code;
    $coachId   = Team::where( 'team_code', $team_code )->first()->user_id;

    $loadSetting = SettingLoadcontrol::where( 'user_id', $coachId )->first()->on_extra_questions;

    return $loadSetting;
}

function checkExtraLoadControlForCoach() {
    $coachId     = Auth::user()->id;
    $loadSetting = SettingLoadcontrol::where( 'user_id', $coachId )->first()->on_extra_questions;

    return $loadSetting;
}

function checkAnswerRecoveryToday() {
    $userId      = Auth::user()->id;
    $team_code   = Auth::user()->team_code;
    $checkAnswer = Question::where( 'team_code', $team_code )->where( 'user_id',
        $userId )->whereNotNull( 'recovery' )->whereDate( 'created_at', Carbon::today()->toDateString() )->exists();

    return $checkAnswer;
}

function checkAnswerLoadToday() {
    $userId      = Auth::user()->id;
    $team_code   = Auth::user()->team_code;
    $checkAnswer = Question::where( 'team_code', $team_code )->where( 'user_id',
        $userId )->whereNotNull( 'load' )->whereDate( 'created_at', Carbon::today()->toDateString() )->exists();

    return $checkAnswer;
}

function coaches( $idAdmin ) {
    $admin   = User::findOrFail( $idAdmin );
    $coaches = $admin->coaches;

    return $coaches;
}

function allMainUsers() {
    $users = User::query()
                 ->whereIn( 'role', [ 'coach', 'admin' ] )
                 ->latest( 'created_at' )
                 ->paginate( 1000 );

    return $users;
}

function teamsOfCoach( $id ) {

    $teamActive = Team::query()
                      ->where( 'active', true )
                      ->where( 'user_id', $id )
                      ->latest( 'created_at' )
                      ->paginate( 10 );

    return $teamActive;
}

function isActiveUser( $id ) {
    $user = Auth::user( $id );
    if ( $user->active == 1 ) {
        true;
    } else {
        false;
    }
}


function generalConditionColor( $generalCondition ) {

    if ( $generalCondition <= 30 ) {
        echo '#cc6666';
    } elseif ( $generalCondition > 30 && $generalCondition <= 70 ) {
        echo '#bc7600';
    } elseif ( $generalCondition >= 70 ) {
        echo '#117215';
    } else {
        echo 'currentColor';
    }
}

function generalConditionSvg( $generalCondition ) {

    if ( $generalCondition <= 30 ) {
        echo '<svg class="w-2.5 h-2.5 text-blue-100 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
  <polyline points="9,1 5,7 8,7 7,11 12,5 9,5 9,1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';
    } elseif ( $generalCondition > 30 && $generalCondition <= 70 ) {
        echo '<div class="w-2.5 h-2.5 text-blue-100 dark:text-blue-300" >!</div>';
    } elseif ( $generalCondition >= 70 ) {
        echo '<svg class="w-2.5 h-2.5 text-blue-100 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>';
    } else {
        echo '-';
    }
}


function dashboardLoadControlTeams( $id = null ) {
// Если нужен только один team по id
    $teams = Team::query()
                 ->where( 'active', true )
                 ->where( 'user_id', $id )
                 ->latest( 'created_at' )
                 ->paginate( 10 );

    $result = [];

    foreach ( $teams as $team ) {
        // Определяем последнюю завершённую неделю (начало и конец)
        $now = Carbon::now();
        // Если сегодня понедельник, то берём прошлую неделю,
        // иначе берём неделю, завершившуюся последним воскресеньем
        if ( $now->isMonday() ) {
            $weekStart = $now->copy()->subWeek()->startOfWeek( Carbon::MONDAY );
        } else {
            $weekStart = $now->copy()->startOfWeek( Carbon::MONDAY )->subWeek();
        }
        $weekEnd = $weekStart->copy()->endOfWeek( Carbon::SUNDAY );

        // Получаем данные по вопросам только активных пользователей
        $records = DB::table( 'questions' )
                     ->join( 'users', 'questions.user_id', '=', 'users.id' )
                     ->where( 'questions.team_code', $team->team_code )
                     ->where( 'users.active', 1 )
                     ->whereBetween( 'questions.created_at', [
                         $weekStart->toDateString(),
                         $weekEnd->toDateString(),
                     ] )
                     ->select( 'questions.recovery', 'questions.load' )
                     ->get();

        // Если записей нет — NULL
        if ( $records->isEmpty() ) {
            $loadAvg     = null;
            $recoveryAvg = null;
        } else {
            $loadAvg     = round( $records->avg( 'load' ), 1 );
            $recoveryAvg = round( $records->avg( 'recovery' ), 1 );
        }

        // Собираем результат
        $result[] = [
            'team_id'      => $team->id,
            'team_code'    => $team->team_code,
            'team_name'    => $team->name ?? '', // если есть поле name
            'week_start'   => $weekStart->toDateString(),
            'week_end'     => $weekEnd->toDateString(),
            'load_avg'     => $loadAvg * 10,
            'recovery_avg' => $recoveryAvg * 10,
        ];
    }

    foreach ( $result as $item ) {
        echo '<a href="/teams/'.$item['team_id'].'" class="flex flex-col items-center rounded-md w-full p-4 shadow-inner select-none dark:bg-gray-900">';
        echo '<div class="font-medium text-2xl pb-3 text-gray-800 dark:text-gray-400">' . $item['team_name'] . ' </div>';
        echo '<div class="font-medium text-xs text-gray-800 dark:text-gray-500 pb-5"> Неделя с ' . $item['week_start'] . ' по ' . $item['week_end'] . '</div>';
        echo '<div class="flex flex-col w-full text-gray-900 dark:text-gray-100">';

        echo '<div class="flex justify-between mb-0">
  <span class="text-xs font-medium text-blue-700 dark:text-gray-400">Среднее восстановление: </span>
  <span class="text-sm font-medium text-blue-700 dark:text-gray-400">' . $item['recovery_avg'] . '%</span>
</div>
<div class="mb-3 w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
  <div class="bg-indigo-500 h-2.5 rounded-full" style="width: ' . $item['recovery_avg'] . '%"></div>
</div>';
        echo '<div class="flex justify-between mb-0">
  <span class="text-xs font-medium text-blue-700 dark:text-gray-400">Средняя нагрузка: </span>
  <span class="text-sm font-medium text-blue-700 dark:text-gray-400">' . $item['load_avg'] . '%</span>
</div>
<div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
  <div class="bg-rose-800 h-2.5 rounded-full" style="width: ' . $item['load_avg'] . '%"></div>
</div>';

        echo '</div></a>';
    }
}

function conditionPlayerIndicate( $value, $direction = 'high', $good = 70, $bad = 40 ) {
    // Define dots styles
    $dot_good   = $value . '%<span class="ml-2" style="color:green;font-weight:bold;">●</span>';
    $dot_medium = $value . '%<span class="ml-2" style="color:orange;font-weight:bold;">●</span>';
    $dot_bad    = $value . '%<span class="ml-2" style="color:red;font-weight:bold;">●</span>';

    // Higher is better
    if ( $direction === 'high' ) {
        if ( $value >= $good ) {
            return $dot_good;
        }
        if ( $value >= $bad ) {
            return $dot_medium;
        }

        return $dot_bad;
    }

    // Lower is better
    if ( $direction === 'low' ) {
        if ( $value <= $good ) {
            return $dot_good;
        }
        if ( $value <= $bad ) {
            return $dot_medium;
        }

        return $dot_bad;
    }

    return '<span style="color:gray;">0 ●</span>'; // fallback
}


function subscriptions() {
    return \App\Models\Subscription::with( 'user' )->get();
}


function getTimesArray() {
    $user = Auth::user();
    $team = Team::where('team_code', $user->team_code)->first();
    $adminId = $team->user_id;
    $settings        = SettingLoadControl::where( 'user_id', $adminId )->first();

    // Таймауты в минутах
    $timeoutRecovery = $settings->question_recovery_min ?? 60;
    $timeoutLoad     = $settings->question_load_min ?? 60;

    // Текущая дата для выборки тренировок на сегодня
    $todayStart = Carbon::today();
    $todayEnd   = Carbon::tomorrow()->subSecond();

    // Получаем все тренировки за сегодня для команды пользователя
    $trainingsToday = Training::where( 'team_code', $user->team_code )
                              ->where( 'active', true )
                              ->whereDate( 'date', $todayStart )
                              ->orderBy( 'date', 'asc' )
                              ->get();

    if ( $trainingsToday->isNotEmpty() ) {
        // Время начала первой тренировки
        $firstTrainingStart = $trainingsToday->first()->start;

        // Время окончания последней тренировки
        $lastTrainingEnd = $trainingsToday->last()->finish;
    } else {
        // На сегодня тренировок нет
        $firstTrainingStart = null;
        $lastTrainingEnd    = null;
    }

    $todayTrainingsStartFinish = [ 'start'                 => $firstTrainingStart,
                                   'finish'                => $lastTrainingEnd,
                                   'question_recovery_min' => $timeoutRecovery,
                                   'question_load_min'     => $timeoutLoad
    ];

    return response()->json( $todayTrainingsStartFinish );
}

function checkTestsForPlayer($id) {
    $hasTests = PlayerTest::where('player_id', $id)->exists();
    return $hasTests;
}
