<?php

namespace App\Http\Controllers;

use App\Models\ClassTraining;
use App\Models\Team;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $teamActive = Team::query()
            ->where('user_id', $userId)
            ->latest('created_at')
            ->paginate(10);

        $trainingActive = Training::query()
            ->where('user_id', $userId)
            ->latest('date')
            ->paginate(1000);
        $trainingClass = ClassTraining::query()
            ->paginate(100);

        return view('trainings.index', compact('teamActive','trainingActive', 'trainingClass'));
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
        $userId = Auth::user()->id;

        $validated = $request->validate([
            'team_code' => ['required', 'max:7'],
            'date' => ['required', 'string', 'date'],
            'start' => ['required', 'string'],
            'finish' => ['required', 'string'],
            'class' => ['required','nullable'],
            'desc' => ['nullable', 'string', 'max:1500'],
            'recovery' => ['nullable'],
            'load' => ['nullable'],
            'link_docs' => ['nullable'],
            'active' => ['nullable', 'boolean'],
        ]);

        $raining = Training::query()->create([
            'user_id' => $userId,
            'team_code' => $validated['team_code'],
            'date' => $validated['date'],
            'start' => $validated['start'],
            'finish' => $validated['finish'],
            'class' => $validated['class'],
            'desc' => $validated['desc'],
            'recovery' => $validated['recovery'],
            'load' => $validated['load'],
            'link_docs' => $validated['link_docs'],
            'active' => true,
        ]);
        return response()->json(['code'=>200, 'message'=>'Запись успешно создана','data' => $raining], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
