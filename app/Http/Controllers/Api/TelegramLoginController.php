<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TelegramToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TelegramLoginController extends Controller
{
    /**
     * Аутентификация пользователя и выдача API токена (Sanctum)
     */
    public function login(Request $request)
    {
        // Валидация входных данных
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Поиск пользователя по email
        $user = User::where('email', $request->email)->first();

        // Проверка пароля
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Неверный email или пароль.'
            ], 401);
        }

        // Генерация Sanctum токена
        $token = $user->createToken('api_token')->plainTextToken;

        // Возврат только нужных полей пользователя
        return response()->json([
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => [
                'id'        => $user->id,
                'name'      => $user->name,
                'last_name' => $user->last_name,
                'email'     => $user->email,
                'role'      => $user->role,
                'active'      => $user->active,
            ],
        ]);
    }

    /**
     * Сохранение или обновление token пользователя по telegram_id
     */
    public function storeToken(Request $request)
    {
        try {
            $validated = $request->validate([
                'telegram_id' => 'required|numeric',
                'user_id'     => 'required|exists:users,id',
                'token'       => 'required|string',
            ]);
        } catch (ValidationException $e) {
            // Возврат ошибок валидации в JSON формате
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);
        }

        // Сохраняем или обновляем токен по telegram_id
        TelegramToken::updateOrCreate(
            ['telegram_id' => $validated['telegram_id']],
            $validated
        );

        return response()->json(['status' => 'ok']);
    }

    /**
     * Получить все Telegram токены (для debug/admin)
     */
    public function allTokens()
    {
        return response()->json(TelegramToken::all());
    }

    /**
     * Получить токен пользователя по telegram_id.
     */
    public function getTokenByTelegramId($telegram_id)
    {
        $record = TelegramToken::where('telegram_id', $telegram_id)->first();
        if (!$record) {
            return response()->json(['error' => 'Токен не найден'], 404);
        }
        $user = User::where('id', $record->user_id)->first();

        return response()->json([
            'user_id' => $record->user_id,
            'token'   => $record->token,
            'user' => $user,
        ]);
    }
}
