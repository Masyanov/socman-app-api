<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
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

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
