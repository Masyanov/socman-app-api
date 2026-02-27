<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AchievementType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementSettingsController extends Controller
{
    /**
     * Показать форму для управления типами достижений тренера.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $allAchievementTypes = AchievementType::all();
        $coachSelectedAchievementTypeIds = Auth::user()->achievementTypes->pluck('id')->toArray();

        return view('teams.index', compact('allAchievementTypes', 'coachSelectedAchievementTypeIds'));
    }

    /**
     * Сохранить (обновить) выбранные типы достижений для тренера.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            // achievements - это массив ID выбранных типов достижений, необязателен (тренер может ничего не выбрать)
            'achievements' => 'nullable|array',
            // Каждый элемент массива должен быть целым числом и существовать в таблице achievement_types
            'achievements.*' => 'integer|exists:achievement_types,id',
        ]);

        $coach = Auth::user();

        // Синхронизируем выбранные типы достижений с отношением "многие ко многим".
        // Метод sync() автоматически добавляет новые, удаляет отсутствующие и оставляет существующие.
        $coach->achievementTypes()->sync($request->input('achievements', []));

        return redirect()->route('teams.index')
                         ->with('success', 'Настройки достижений успешно обновлены!');
    }
}
