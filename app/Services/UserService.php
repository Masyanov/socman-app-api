<?php
namespace App\Services;

use App\Models\SettingLoadcontrol;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data)
    {
        $user = User::create([
            'name'      => $validated['name'],
            'last_name' => $validated['last_name'],
            'role'      => $validated['role'],
            'team_code' => $validated['team_code'],
            'email'     => $validated['email'],
            'password'  => Hash::make( $validated['password'] ),
        ]);
        UserMeta::create( [
            'user_id' => $user->id,
        ] );

        if ( $validated['role'] == 'coach' ) {
            SettingLoadcontrol::create( [
                'user_id'               => $user->id,
                'on_load'               => 0,
                'on_extra_questions'    => 0,
                'question_recovery_min' => 60,
                'question_load_min'     => 60,
            ] );
        }

    }
}
