<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\UserMeta;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $teamActive = Team::query()
            ->where('user_id', $userId)
            ->paginate(100);

        return view('users.index', compact('teamActive'));
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'role' => $request->role,
            'team_code' => $request->team_code,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        UserMeta::create([
            'user_id' => $user->id,
        ]);

        event(new Registered($user));

        $userId = Auth::user()->id;

        $teamActive = Team::query()
            ->where('user_id', $userId)
            ->paginate(100);

        return view('users.index', compact('teamActive'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $player = User::where('id', $id)->first();

        return view('users.user', compact('player'));
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
    public function update(Request $request)
    {
        if ($request->active) {
            $active = 1;
        } else {
            $active = 0;
        }

        $userEmail = User::where('id', $request->player_id)->first()->email;

        if ($request->email != $userEmail) {
            $request->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            ]);
        }

        $request->validate([
            'avatar' => 'image',
        ]);

        $userAvatar = UserMeta::where('user_id', $request->player_id)->first()->avatar;

        if (isset($request->avatar)) {
            $avatarName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);
        } else {
            $avatarName = $userAvatar;
        }

        User::where('id', $request->player_id)->first()->update([
            'name' => $request->name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'active' => $active,
        ]);

        UserMeta::where('user_id', $request->player_id)->first()->update([
            'tel' => $request->tel,
            'position' => $request->position,
            'number' => $request->number,
            'tel_mother' => $request->tel_mother,
            'tel_father' => $request->tel_father,
            'comment' => $request->comment,
            'avatar' => $avatarName,
        ]);

        $player = User::where('id', $request->player_id)->first();

        return view('users.user', compact('player'))->with('status', 'profile-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();

        return response()->json(['success' => 'Запись успешно удалена']);
    }
}
