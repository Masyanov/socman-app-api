<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PresenceTraining;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Training;

class AttendanceCalendarController extends Controller {
    public function index(Request $request)
    {
        $month    = $request->input('month', Carbon::now()->format('Y-m'));
        $teamCode = $request->input('team_code');

        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate   = (clone $startDate)->endOfMonth();

        $users = User::where('team_code', $teamCode)
                     ->where('active', true)
                     ->get();

        // Получаем даты активных тренировок
        $days = Training::where('team_code', $teamCode)
                        ->where('active', true)
                        ->whereBetween('date', [$startDate, $endDate])
                        ->orderBy('date')
                        ->pluck('date')
                        ->map(function ($date) {
                            return Carbon::parse($date);
                        })
                        ->unique(function ($date) {
                            // избавляемся от дублей по дню
                            return $date->toDateString();
                        })
                        ->values();

        // Получаем посещаемость, фильтруя только по этим дням
        $presences = PresenceTraining::with('training')
                                     ->where('team_code', $teamCode)
                                     ->whereHas('training', function ($q) use ($days) {
                                         $q->whereIn('date', $days->map->toDateString());
                                     })
                                     ->get()
                                     ->groupBy(function ($presence) {
                                         return $presence->user_id . '_' . Carbon::parse($presence->training->date)->toDateString();
                                     });

        if ($request->ajax()) {
            return view('attendance.partials.table', compact('users', 'days', 'presences'))->render();
        }

        return view('attendance.calendar', compact(
            'month', 'teamCode', 'users', 'days', 'presences'
        ));
    }
}
