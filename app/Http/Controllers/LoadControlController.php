<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoadControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = '111';

        return view('questions.index', compact('userId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $team_code = Auth::user()->team_code;

        $validated = $request->validate([
            'user_id' => ['required'],
            'pain' => ['required', 'nullable'],
            'local' => ['nullable'],
            'sleep' => ['required', 'nullable'],
            'sleep_time' => ['required', 'nullable'],
            'moral' => ['required', 'nullable'],
            'physical' => ['required', 'nullable'],
            'presence_checkNum' => ['required', 'nullable'],
            'cause' => ['nullable'],
            'recovery' => ['required', 'nullable'],
        ]);

        $today = Carbon::today();

        $existingRecord = Question::where('user_id', $user_id)
                                  ->whereDate('created_at', $today)
                                  ->first();

        if ($existingRecord) {
            return response()->json(['code' => 200, 'message' => 'Запись успешно создана', 'data' => $question], 200);
        } else {
            $question = Question::query()->create([
                'user_id' => $user_id,
                'team_code' => $team_code,
                'pain' => $validated['pain'],
                'local' => $validated['local'],
                'sleep' => $validated['sleep'],
                'sleep_time' => $validated['sleep_time'],
                'moral' => $validated['moral'],
                'physical' => $validated['physical'],
                'presence_checkNum' => $validated['presence_checkNum'],
                'cause' => $validated['cause'],
                'recovery' => $validated['recovery'],
            ]);

            return response()->json(['code' => 200, 'message' => 'Запись успешно создана', 'data' => $question], 200);
        }




    }

    /**
     * Display the specified resource.
     */
    public function show(LoadControlController $loadControlController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoadControlController $loadControlController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $userId = Auth::user()->id;
        $team_code = Auth::user()->team_code;
        if (checkAnswerRecoveryToday()) {
            $question = Question::where('user_id', $userId)->whereDate('created_at', Carbon::today()->toDateString())->update([
                'load' => $request->load,
            ]);
        } else {
            $question = Question::query()->create([
                'user_id' => $userId,
                'team_code' => $team_code,
                'pain' => null,
                'local' => null,
                'sleep' => null,
                'sleep_time' => null,
                'moral' => null,
                'physical' => null,
                'presence_checkNum' => null,
                'cause' => null,
                'recovery' => null,
                'load' => $request->load,
            ]);
        }

        return response()->json(['code' => 200, 'message' => 'Запись успешно создана', 'data' => $question], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Question::where('id', $id)->delete();
    }
}
