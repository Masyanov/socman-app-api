<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;

        $teamActive = Team::query()
            ->where('user_id', $userId)
            ->latest('created_at')
            ->paginate(10);

        if ($request->ajax()) {
            return view('teams.index', ['teamActive' => $teamActive])->render();
        }

        return view('teams.index', compact('teamActive'));
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
            'name' => ['required', 'string', 'max:1500'],
            'team_code' => ['required', 'max:7', 'unique:teams,team_code'],
            'desc' => ['nullable'],
            'active' => ['nullable', 'boolean'],
        ]);

        $team = Team::query()->create([
            'user_id' => $userId,
            'name' => $validated['name'],
            'team_code' => $validated['team_code'],
            'desc' => $validated['desc'],
            'active' => true,
        ]);

        return response()->json(['code'=>200, 'message'=>'Запись успешно создана','data' => $team], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $userId = Auth::user()->id;

        $team = Team::where('id', $team->id)->where('user_id', $userId)->first();

        $usersOfTeam = User::query()
            ->where('team_code', $team->team_code)
            ->latest('created_at')
            ->paginate(10);

        return view('teams.team', compact('team', 'usersOfTeam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $team->update([
            'name' => $request->name,
            'team_code' => $request->team_code,
            'desc' => $request->desc,
            'active' => $request->active,
        ]);

        return response()->json(['code'=>200, 'message'=>'Запись успешно создана','data' => $request->active], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json(['success' => 'Запись успешно удалена']);

    }
}
