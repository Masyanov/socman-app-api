<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        $userId = Auth::user()->id;

        $teams = Team::query()
                          ->where( 'user_id', $userId )
                          ->latest( 'created_at' )
                          ->paginate( 10 );

        if ( $request->ajax() ) {
            return view( 'tests.index', [ 'teams' => $teams ] )->render();
        }


        return view( 'tests.index', compact( 'teams' ) );
    }

    public function getPlayersForTeam($teamId)
    {

        $players = User::where('team_code', $teamId)->get(['id', 'name', 'last_name']);

        return response()->json($players);
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
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'team_code' => 'nullable|string|max:255',
            'date_of_test' => 'required|date',
            'full_name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'leading_leg' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'body_mass_index' => 'nullable|numeric',
            'push_ups' => 'nullable|integer',
            'pull_ups' => 'nullable|integer',
            'ten_m' => 'nullable|numeric',
            'twenty_m' => 'nullable|numeric',
            'thirty_m' => 'nullable|numeric',
            'long_jump' => 'nullable|numeric',
            'vertical_jump_no_hands' => 'nullable|numeric',
            'vertical_jump_with_hands' => 'nullable|numeric',
            'illinois_test' => 'nullable|numeric',
            'pause_one' => 'nullable|integer',
            'pause_two' => 'nullable|integer',
            'pause_three' => 'nullable|integer',
            'step' => 'nullable|integer',
            'mpk' => 'nullable|numeric',
            'level' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        Test::create($validated);

        return redirect()->route('tests.create')->with('success', 'Player test data added successfully.');
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
