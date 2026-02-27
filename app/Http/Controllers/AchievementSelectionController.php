<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AchievementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementSelectionController extends Controller
{
    public function __construct()
    {
        // Только для авторизованных пользователей, которые являются тренерами
        $this->middleware('auth');
        // Если у вас есть middleware для ролей, добавьте его здесь:
        // $this->middleware('can:manage-achievements'); // Например, если используете Spatie Permissions
    }

    /**
     * Показать форму выбора метрик для текущего тренера.
     * Возвращает все доступные метрики и те, что уже выбраны тренером.
     */
    public function index()
    {
        $coach = Auth::user(); // Текущий авторизованный тренер

        // Убедимся, что это тренер, если у вас есть роли
        if (!$coach->isCoach()) { // Метод isCoach() в модели User
            abort(403, 'Доступ запрещен. Вы не тренер.');
        }

        $allAchievementTypes = AchievementType::all(); // Все метрики в системе
        $selectedAchievementTypeIds = $coach->coachAchievementTypes()->pluck('id')->toArray();

        // Передаем данные во View для отображения формы с чекбоксами
        return view('coach.achievements.index', compact('allAchievementTypes', 'selectedAchievementTypeIds'));
    }

    /**
     * Сохранить выбранные тренером метрики.
     */
    public function update(Request $request)
    {
        $coach = Auth::user(); // Текущий авторизованный тренер

        if (!$coach->isCoach()) {
            abort(403, 'Доступ запрещен. Вы не тренер.');
        }

        // Валидация: получаем массив ID метрик, которые выбрал тренер
        $data = $request->validate([
            'achievement_type_ids' => 'array',
            'achievement_type_ids.*' => 'exists:achievement_types,id'
        ]);

        // Метод sync отвяжет старые и привяжет новые метрики к тренеру
        $coach->coachAchievementTypes()->sync($data['achievement_type_ids'] ?? []);

        return redirect()->back()->with('success', __('messages.Набор достижений успешно обновлен.'));
    }
}
