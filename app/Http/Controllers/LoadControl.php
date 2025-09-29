<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\SettingLoadcontrol;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoadControl extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $user = Auth::user();

        // Предположим, что у пользователя есть связь teams
        $teams = Team::whereHas('user', function($query) use ($user) {
            $query->where('id', $user->id);
        })->get();

        $answers = Question::whereHas('team', function ($query) use ($user) {
            $query->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        })->paginate(12);

        $settings = SettingLoadcontrol::where('user_id', $userId)->first();

        return view('loadcontrol.index', compact('userId', 'settings', 'answers', 'teams'));
    }

    public function filter(Request $request)
    {
        $user = Auth::user();

        $query = Question::query();

        // Фильтрация по дате
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // Фильтрация по команде через whereHas с условием team_code
        if ($request->filled('team_code')) {
            $query->whereHas('team', function ($q) use ($request) {
                $q->where('team_code', $request->team_code);
            });
        } else {
            // Фильтрация по команде пользователя, если команда в фильтре не выбрана
            $query->whereHas('team', function ($q) use ($user) {
                $q->whereHas('user', function ($q2) use ($user){
                    $q2->where('id', $user->id);
                });
            });
        }

        $answers = $query->paginate(12);

        return view('loadcontrol.partials.answers_table_body', compact('answers'))->render();
    }

    public function update(Request $request)
    {
        SettingLoadcontrol::where('user_id', $request->user_id)->first()->update([
            'on_load' => $request->on_loadNum,
            'on_extra_questions' => $request->on_extra_questionsNum,
            'question_recovery_min' => $request->question_recovery_min,
            'question_load_min' => $request->question_load_min,
        ]);

        return response()->json(['code' => 200, 'success' => 'Запись успешно создана', 'data' => $request], 200);
    }

}
