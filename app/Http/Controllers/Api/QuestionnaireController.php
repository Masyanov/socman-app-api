<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionnaireAnswer;
use App\Models\TelegramToken;
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

        $question = Question::query()->create( [
            'user_id'           => $user_id,
            'team_code'         => $team_code,
            'pain'              => $validated['pain'],
            'local'             => $validated['local'],
            'sleep'             => $validated['sleep'],
            'sleep_time'        => $validated['sleep_time'],
            'moral'             => $validated['moral'],
            'physical'          => $validated['physical'],
            'presence_checkNum' => $validated['presence_checkNum'] ?? null,
            'cause'             => $validated['cause'] ?? null,
            'recovery'          => $validated['recovery'],
        ] );

        return response()->json( [
            'success' => true,
            'id'      => $question->id,
            'message' => 'Ответ сохранен',
        ], 200 );
    }

    public function storeAfterTrainingPoll(Request $request)
    {
        $telegram_id = TelegramToken::where('telegram_id', $request->user_id)->first();

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
                'message' => 'Пользователь не найден',
            ], 404);
        }

        $team_code = $user->team_code;

        $question = Question::where('user_id', $user_id)
                            ->whereDate('created_at', Carbon::today()->toDateString())
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
                'message' => 'Новый ответ создан',
            ], 201);
        }

        // Обновляем существующую запись
        $question->load = $request->load;
        $question->save();

        return response()->json([
            'success' => true,
            'id' => $question->id,
            'message' => 'Ответ обновлён',
        ], 200);
    }

    public function checkQuestionAlreadyAnswered($user_id) {

        $today = Carbon::today();

        $answered = Question::where('user_id', $user_id)
                                 ->whereDate('created_at', $today)
                                 ->exists();

        return response()->json($answered);
    }
}
