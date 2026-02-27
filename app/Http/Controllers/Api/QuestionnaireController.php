<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionnaireAnswer;
use App\Models\SettingLoadcontrol;
use App\Models\TelegramToken;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller {
    public function storeUntilTrainingPoll( Request $request ) {
        $telegram_id = TelegramToken::where( 'telegram_id', $request->user_id )->first();
        $user_id     = $telegram_id->user_id;

        $user      = User::where( 'id', $user_id )->first();
        $team_code = $user->team_code;

        $validated = $request->validate( [
            'pain'              => [ 'required', 'nullable' ],
            'local'             => [ 'nullable' ],
            'sleep'             => [ 'required', 'nullable' ],
            'sleep_time'        => [ 'required', 'nullable' ],
            'moral'             => [ 'required', 'nullable' ],
            'physical'          => [ 'required', 'nullable' ],
            'presence_checkNum' => [ 'nullable' ],
            'cause'             => [ 'nullable' ],
            'recovery'          => [ 'required', 'nullable' ],
        ] );

        $today = Carbon::today();
        $question = Question::where( 'user_id', $user_id )
                            ->whereDate( 'created_at', $today )
                            ->first();

        if ( $question ) {
            // Обновляем существующую запись за сегодня
            $question->team_code         = $team_code;
            $question->pain              = $validated['pain'];
            $question->local             = $validated['local'] ?? null;
            $question->sleep             = $validated['sleep'];
            $question->sleep_time        = $validated['sleep_time'] ?? null;
            $question->moral             = $validated['moral'];
            $question->physical          = $validated['physical'];
            $question->presence_checkNum = $validated['presence_checkNum'] ?? null;
            $question->cause             = $validated['cause'] ?? null;
            $question->recovery          = $validated['recovery'];
            $question->save();

            return response()->json( [
                'success' => true,
                'id'      => $question->id,
                'message' => __('messages.Ответ обновлён'),
            ], 200 );
        }

        // Создаём новую запись, если за сегодня ещё не было
        $question = Question::query()->create( [
            'user_id'           => $user_id,
            'team_code'         => $team_code,
            'pain'              => $validated['pain'],
            'local'             => $validated['local'] ?? null,
            'sleep'             => $validated['sleep'],
            'sleep_time'        => $validated['sleep_time'] ?? null,
            'moral'             => $validated['moral'],
            'physical'          => $validated['physical'],
            'presence_checkNum' => $validated['presence_checkNum'] ?? null,
            'cause'             => $validated['cause'] ?? null,
            'recovery'          => $validated['recovery'],
        ] );

        return response()->json( [
            'success' => true,
            'id'      => $question->id,
            'message' => __('messages.Ответ сохранен'),
        ], 201 );
    }

    public function storeAfterTrainingPoll(Request $request)
    {
        $telegramIdFromRequest = $request->input('user_id') ?? $request->input('telegram_id');
        $telegram_id = TelegramToken::where('telegram_id', $telegramIdFromRequest)->first();

        if (!$telegram_id) {
            return response()->json([
                'success' => false,
                'message' => 'Telegram ID не найден',
            ], 404);
        }

        $user_id = $telegram_id->user_id;

        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => __('messages.Пользователь не найден'),
            ], 404);
        }

        $today = Carbon::today();

        // Один раз в день: уже отвечал на вопрос о нагрузке сегодня?
        $alreadyAnsweredLoad = Question::where('user_id', $user_id)
            ->whereDate('created_at', $today)
            ->whereNotNull('load')
            ->exists();

        if ($alreadyAnsweredLoad) {
            \Log::info('Load survey: already answered today', ['user_id' => $user_id, 'telegram_id' => $telegramIdFromRequest]);
            return response()->json([
                'success' => false,
                'reason'   => 'already_answered',
                'message'  => __('messages.Сегодня вы ответили на вопрос о нагрузке'),
            ], 400);
        }

        // Окно времени: ответ возможен только в течение question_load_min минут после окончания тренировки
        $trainingsFinishedToday = Training::where('team_code', $user->team_code)
            ->whereDate('date', $today)
            ->where('active', true)
            ->where('finish', '<=', Carbon::now()->format('H:i:s'))
            ->orderBy('finish', 'desc')
            ->get();

        $stillInWindow = false;
        foreach ($trainingsFinishedToday as $t) {
            $finishDt = Carbon::parse($t->date . ' ' . $t->finish);
            $settings = SettingLoadcontrol::where('user_id', $t->user_id)->first();
            $loadMin = (int) ($settings->question_load_min ?? 60);
            $deadline = $finishDt->copy()->addMinutes($loadMin);
            if (Carbon::now()->lessThan($deadline)) {
                $stillInWindow = true;
                break;
            }
        }

        if (!$stillInWindow) {
            return response()->json([
                'success' => false,
                'reason'   => 'time_expired',
                'message'  => __('messages.Время для ответа о нагрузке вышло.'),
            ], 400);
        }

        $request->validate([
            'load' => ['required', 'numeric', 'min:0', 'max:10'],
        ]);

        $team_code = $user->team_code;

        $question = Question::where('user_id', $user_id)
                            ->whereDate('created_at', $today)
                            ->first();

        if (!$question) {
            // Создаём новую запись
            $question = new Question();
            $question->user_id = $user_id;
            $question->team_code = $team_code; // если есть такое поле в таблице
            $question->load = $request->load;
            // Можно заполнить другие нужные поля, если есть
            $question->save();

            return response()->json([
                'success' => true,
                'id' => $question->id,
                'message' => __('messages.Новый ответ создан'),
            ], 201);
        }

        // Обновляем существующую запись
        $question->load = $request->load;
        $question->save();

        return response()->json([
            'success' => true,
            'id' => $question->id,
            'message' => __('messages.Ответ обновлён'),
        ], 200);
    }

    public function checkQuestionAlreadyAnswered($user_id) {

        $today = Carbon::today();

        // Учитываем только ответ по восстановлению (recovery), а не любую анкету за день
        $answered = Question::where('user_id', $user_id)
                                 ->whereDate('created_at', $today)
                                 ->whereNotNull('recovery')
                                 ->exists();

        return response()->json($answered);
    }

    /**
     * Проверка, может ли пользователь ответить на опрос о нагрузке (для бота).
     * Возвращает: allowed, при reason — already_answered | time_expired | no_training и message.
     */
    public function checkLoadSurveyAllowed($user_id)
    {
        $user = User::find($user_id);
        if (!$user || !$user->team_code) {
            return response()->json([
                'allowed' => false,
                'reason'  => 'no_training',
                'message' => __('messages.Время для ответа о нагрузке вышло.'),
            ]);
        }

        $today = Carbon::today();

        $alreadyAnsweredLoad = Question::where('user_id', $user_id)
            ->whereDate('created_at', $today)
            ->whereNotNull('load')
            ->exists();

        if ($alreadyAnsweredLoad) {
            return response()->json([
                'allowed' => false,
                'reason'  => 'already_answered',
                'message' => __('messages.Сегодня вы ответили на вопрос о нагрузке'),
            ]);
        }

        $trainingsFinishedToday = Training::where('team_code', $user->team_code)
            ->whereDate('date', $today)
            ->where('active', true)
            ->where('finish', '<=', Carbon::now()->format('H:i:s'))
            ->orderBy('finish', 'desc')
            ->get();

        foreach ($trainingsFinishedToday as $t) {
            $finishDt = Carbon::parse($t->date . ' ' . $t->finish);
            $settings = SettingLoadcontrol::where('user_id', $t->user_id)->first();
            $loadMin = (int) ($settings->question_load_min ?? 60);
            $deadline = $finishDt->copy()->addMinutes($loadMin);
            if (Carbon::now()->lessThan($deadline)) {
                return response()->json([
                    'allowed' => true,
                    'message' => null,
                ]);
            }
        }

        return response()->json([
            'allowed' => false,
            'reason'  => 'time_expired',
            'message' => __('messages.Время для ответа о нагрузке вышло.'),
        ]);
    }
}
