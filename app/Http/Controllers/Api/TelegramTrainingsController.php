<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Training;
use App\Models\SettingLoadcontrol;
use App\Models\TrainingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;

class TelegramTrainingsController extends Controller {
    public function trainings( Request $request ) {
        Carbon::setLocale( 'ru' );
        $today = Carbon::today(); // Текущая дата без времени
        $now   = Carbon::now();

        $query = Training::where( 'active', true )
                         ->where( function ( $sub ) use ( $today, $now ) {
                             $sub->where( 'date', '>', $today )
                                 ->orWhere( function ( $q ) use ( $today, $now ) {
                                     $q->where( 'date', $today )
                                       ->where( 'start', '>', $now->format( 'H:i:s' ) );
                                 } );
                         } );

        if ( $request->has( 'team_code' ) ) {
            $query->where( 'team_code', $request->input( 'team_code' ) );
        }

        $trainings = $query->orderBy( 'date', 'ASC' ) // сортируем по возрастанию даты — сначала ближайшие
                           ->limit( 5 )
                           ->get( [ 'date', 'desc', 'addresses', 'start', 'finish' ] );

        // Преобразуем дату в нужный формат
        $trainings->transform( function ( $training ) {
            // Если поле date хранится в формате datetime или date
            $date = Carbon::parse( $training->date );
            // Форматируем: 1 марта 2025
            $training->date = $date->translatedFormat( 'j F Y' );

            // Парсим и форматируем время начала (start) и окончания (finish)
            $training->start  = Carbon::parse( $training->start )->format( 'H:i' );
            $training->finish = Carbon::parse( $training->finish )->format( 'H:i' );

            if ( is_array( $training->addresses ) ) {
                $training->addresses = array_map( 'nameAddress', $training->addresses );
            } else {
                $training->addresses = nameAddress( $training->addresses );
            }

            return $training;
        } );

        return response()->json( [
            'success'   => true,
            'trainings' => $trainings
        ] );
    }

    public function trainingsNotify() {
        $now       = Carbon::now();
        $today     = Carbon::today();
        // 1–24 в настройке интерпретируем как часы (в БД хранится как число)
        $trainings = Training::query()
                             ->join( 'setting_loadcontrols as sl', 'trainings.user_id', '=', 'sl.user_id' )
                             ->where( 'trainings.start', '>=', $now )
                             ->where( 'active', true )
                             ->where( 'date', $today )
                             ->where( 'trainings.notified', false )
                             ->whereRaw( "? >= DATE_SUB(trainings.start, INTERVAL (CASE WHEN sl.question_recovery_min BETWEEN 1 AND 24 THEN sl.question_recovery_min * 60 ELSE sl.question_recovery_min END) MINUTE)",
                                 [ $now ] )
                             ->select( 'trainings.*', 'sl.question_recovery_min' )
                             ->get();

        $result = [];

        foreach ( $trainings as $training ) {

            $users = User::where( 'team_code', $training->team_code )
                         ->where( 'active', true )
                         ->whereHas( 'meta', function ( $query ) {
                             $query->whereNotNull( 'telegram_id' )->where( 'telegram_id', '!=', '' );
                         } )
                         ->get();


            if ( ! $users ) {
                continue; // нет пользователя - пропускаем
            }

            // Собираем массив telegram_id из пользователей
            $telegram_ids = $users->map( function ( $user ) {
                return $user->meta->telegram_id;
            } )->toArray();

            $trainingStart = Carbon::parse( $training->start )->format( 'H:i' );

            $result[] = [
                'training_id' => $training->id,
                'telegram_id' => $telegram_ids,
                'start'       => $trainingStart,
            ];

        }

        return response()->json( [
            'success'   => true,
            'trainings' => $result,
        ] );
    }

    public function afterTrainingPollNotify() {
        $now   = Carbon::now();
        $today = Carbon::today();

        $trainings = Training::query()
                             ->join( 'setting_loadcontrols as sl', 'trainings.user_id', '=', 'sl.user_id' )
                             ->where( 'trainings.finish', '<=', $now )
                             ->where( 'active', true )
                             ->where( 'trainings.date', $today )
                             ->where( 'trainings.notified_after_training', false )
                             ->whereRaw( '? < DATE_ADD(trainings.finish, INTERVAL sl.question_load_min MINUTE)',
                                 [ $now ]
                             )
                             ->select( 'trainings.*', 'sl.question_load_min' )
                             ->get();

        $result = [];

        foreach ( $trainings as $training ) {

            $users = User::where( 'team_code', $training->team_code )
                         ->where( 'active', true )
                         ->whereHas( 'meta', function ( $query ) {
                             $query->whereNotNull( 'telegram_id' )->where( 'telegram_id', '!=', '' );
                         } )
                         ->get();


            if ( ! $users ) {
                continue; // нет пользователя - пропускаем
            }

            // Собираем массив telegram_id из пользователей
            $telegram_ids = $users->map( function ( $user ) {
                return $user->meta->telegram_id;
            } )->toArray();

            $trainingFinish = Carbon::parse( $training->finish )->format( 'H:i' );

            $result[] = [
                'training_id' => $training->id,
                'telegram_id' => $telegram_ids,
                'finish'      => $trainingFinish,
            ];

        }

        return response()->json( [
            'success'   => true,
            'trainings' => $result,
        ] );
    }

    // Проверяет, есть ли ответы на анкету для тренировки
    private function hasAnswered( $training_id, $user_id ) {
        return Question::where( 'training_id', $training_id )
                       ->where( 'user_id', $user_id )
                       ->exists();
    }

    public function markSent( $training_id ) {
        $training = Training::find( $training_id );

        if ( ! $training ) {
            return response()->json( [
                'success' => false,
                'message' => 'Training not found.'
            ], 404 );
        }

        $training->notified = true;
        $training->save();

        return response()->json( [
            'success' => true,
            'message' => 'Training marked as notified.'
        ] );
    }

    public function markSentAfter( $training_id ) {
        $training = Training::find( $training_id );

        if ( ! $training ) {
            return response()->json( [
                'success' => false,
                'message' => 'Training not found.'
            ], 404 );
        }

        $training->notified_after_training = true;
        $training->save();

        return response()->json( [
            'success' => true,
            'message' => 'Training marked as notified.'
        ] );
    }

    /**
     * То же, что questionReady, но team_code берётся из пользователя (когда у пользователя team_code пустой в профиле).
     */
    public function questionReadyByUser( $userId ) {
        $user = User::find( $userId );
        if ( ! $user || ! $user->team_code ) {
            return response()->json( [
                'question_ready' => false,
                'message'        => __( 'messages.Тренировка не найдена' )
            ] );
        }
        return $this->questionReady( $user->team_code );
    }

    public function questionReady( $teamCode ) {
        $now = Carbon::now();
        // team_code может прийти как строка "None" из бота, если в профиле пользователя team_code пустой
        if ( $teamCode === 'None' || $teamCode === '' || $teamCode === null ) {
            return response()->json( [
                'question_ready' => false,
                'message'        => __( 'messages.Тренировка не найдена' )
            ] );
        }
        \Log::info( "questionReady called for teamCode: {$teamCode}, now: " . $now->toDateTimeString() );

        // Ближайшая предстоящая тренировка сегодня (не уже начавшаяся)
        $trainingsToday = Training::where( 'team_code', $teamCode )
                                 ->whereDate( 'date', $now->toDateString() )
                                 ->orderBy( 'start', 'asc' )
                                 ->get();

        $training = $trainingsToday->first( function ( $t ) use ( $now ) {
            $start = Carbon::parse( $t->date . ' ' . $t->start );
            return $start->greaterThan( $now );
        } );

        if ( ! $training ) {
            return response()->json( [
                'question_ready' => false,
                'message'        => __( 'messages.Тренировка не найдена' )
            ] );
        }

        // Get user's settings for how many minutes (or hours) before training questionnaire is allowed
        $settings  = SettingLoadcontrol::where( 'user_id', $training->user_id )->first();
        $rawValue  = $settings?->question_recovery_min ?? 0;
        // Значения 1–24 часто вводят как «часы»; интерпретируем их как часы (×60 минут)
        $settingsTimeBeforeTraining = ( $rawValue >= 1 && $rawValue <= 24 ) ? (int) $rawValue * 60 : (int) $rawValue;

        // Combine training date and start time
        $trainingStart = Carbon::parse( $training->date . ' ' . $training->start );

        // Calculate when questionnaire is allowed from
        $allowedStartTime = $trainingStart->copy()->subMinutes( $settingsTimeBeforeTraining );

        \Log::info( "training_start: " . $trainingStart->toDateTimeString() . ", allowed_from: " . $allowedStartTime->toDateTimeString() );

        // If training already started — questionnaire should NOT be allowed
        if ( $now->greaterThanOrEqualTo( $trainingStart ) ) {
            \Log::info( "questionReady: training already started, returning false" );

            return response()->json( [
                'question_ready' => false,
                'training_start' => $trainingStart->toDateTimeString(),
                'allowed_from'   => $allowedStartTime->toDateTimeString(),
                'limit_minutes'  => $settingsTimeBeforeTraining,
                'message'        => __( 'messages.Тренировка уже началась' )
            ] );
        }

        // Only allow if current time is within [allowedStartTime, trainingStart)
        $ready = $now->greaterThanOrEqualTo( $allowedStartTime ) && $now->lessThan( $trainingStart );

        return response()->json( [
            'question_ready'   => $ready,
            'training_start'   => $trainingStart->toDateTimeString(),
            'date'             => $training->date,
            'start'            => $training->start,
            'allowed_from'     => $allowedStartTime->toDateTimeString(),
            'limit_minutes'    => $settingsTimeBeforeTraining,
            'raw_setting_min'  => $rawValue,
            'message'          => $ready ? '' : __( 'messages.Окно опроса недоступно' )
        ] );
    }

    /**
     * Для бота: время на опрос (в минутах). team_code в query.
     * Значения 1–24 интерпретируются как часы (×60).
     */
    public function timeForQuestions( Request $request ) {
        $teamCode = $request->query( 'team_code' );
        if ( ! $teamCode ) {
            return response()->json( [ 'minutes' => 0, 'hours' => 0 ] );
        }
        $training = Training::where( 'team_code', $teamCode )->first();
        if ( ! $training ) {
            return response()->json( [ 'minutes' => 0, 'hours' => 0 ] );
        }
        $settings = SettingLoadcontrol::where( 'user_id', $training->user_id )->first();
        $rawValue = $settings?->question_recovery_min ?? 0;
        $minutes  = ( $rawValue >= 1 && $rawValue <= 24 ) ? (int) $rawValue * 60 : (int) $rawValue;
        $hours    = round( $minutes / 60, 1 );
        return response()->json( [ 'minutes' => $minutes, 'hours' => $hours ] );
    }

}
