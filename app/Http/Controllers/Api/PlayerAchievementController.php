<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AchievementType;
use App\Models\PlayerAchievement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerAchievementController extends Controller
{
    /**
     * Получить список доступных метрик (для кнопок в боте).
     */
    public function getTypes(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::with('team.coach.achievementTypes')->find($request->user_id);

        if ($user && $user->team && $user->team->coach) {
            return response()->json($user->team->coach->achievementTypes);
        }

        return response()->json([], 200);
    }

    /**
     * Сохранить новое достижение (запрос от Бота).
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'achievement_type_key' => 'required|string|exists:achievement_types,key',
            'value' => 'required|numeric',
            'recorded_at' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $type = AchievementType::where('key', $validated['achievement_type_key'])->first();

        // Создаем запись
        $achievement = PlayerAchievement::create([
            'user_id' => $validated['user_id'],
            'achievement_type_id' => $type->id,
            'value' => $validated['value'],
            'recorded_at' => $validated['recorded_at'] ?? now(),
        ]);

        return response()->json([
            'message' => __('messages.Результат успешно сохранен'),
            'data' => $achievement
        ], 201);
    }

    /**
     * Получить историю прогресса игрока по конкретной метрике.
     * Полезно для построения графиков.
     */
    public function history(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'achievement_type_key' => 'required|exists:achievement_types,key',
        ]);

        $type = AchievementType::where('key', $request->achievement_type_key)->first();

        $history = PlayerAchievement::where('user_id', $request->user_id)
                                    ->where('achievement_type_id', $type->id)
                                    ->orderBy('recorded_at', 'asc')
                                    ->get(['recorded_at', 'value']);

        $totalValue = $history->sum('value');

        return response()->json([
            'metric' => $type->name,
            'unit' => $type->unit,
            'total_value' => $totalValue,
            'history' => $history
        ]);
    }
}
