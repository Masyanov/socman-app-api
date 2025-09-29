<?php

namespace Database\Seeders;

use App\Models\SettingLoadcontrol;
use App\Models\SettingUser;
use App\Models\Team;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $superAdmin = User::create( [
            'name'              => 'Алексей',
            'last_name'         => 'Масьянов',
            'role'              => 'super-admin',
            'team_code'         => '',
            'email'             => 'masyanov.aleksei@gmail.com',
            'email_verified_at' => now(),
            'password'          => 'Qaz19027',
            'load_control'      => 0,
            'remember_token'    => Str::random( 10 ),
            'active'            => 1,
        ] );

        $admin = User::create( [
            'name'              => 'Владимир',
            'last_name'         => 'Админов',
            'role'              => 'admin',
            'team_code'         => '',
            'email'             => 'masyanov.aleksei1@gmail.com',
            'email_verified_at' => now(),
            'password'          => 'Qaz19027',
            'load_control'      => 0,
            'remember_token'    => Str::random( 10 ),
            'active'            => 1,
        ] );

        $coach = User::create( [
            'name'              => 'Карло',
            'last_name'         => 'Анчелотти',
            'role'              => 'coach',
            'team_code'         => '',
            'email'             => 'masyanov.aleksei2@gmail.com',
            'email_verified_at' => now(),
            'password'          => 'Qaz19027',
            'load_control'      => 1,
            'remember_token'    => Str::random( 10 ),
            'active'            => 1,
        ] );
        UserMeta::create( [
            'user_id' => $superAdmin->id,
        ] );
        UserMeta::create( [
            'user_id' => $admin->id,
        ] );
        $code = Str::random( 10 );

        SettingUser::create( [
            'user_id' => $admin->id,
            'slug'    => 'referral_code',
            'value'   => $code,
            'active'  => true
        ] );

        UserMeta::create( [
            'user_id' => $coach->id,
        ] );

        SettingLoadcontrol::create( [
            'user_id'               => $coach->id,
            'on_load'               => 1,
            'on_extra_questions'    => 1,
            'question_recovery_min' => 60,
            'question_load_min'     => 60,
        ] );


        $teams = Team::all();

        foreach ( $teams as $team ) {
            for ( $i = 0; $i < 22; $i ++ ) {
                $user = User::create( [
                    'name'              => fake()->firstName(),
                    'last_name'         => fake()->lastName(),
                    'role'              => 'player',
                    'team_code'         => $team->team_code,
                    'email'             => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password'          => bcrypt( 'secret' ),
                    'remember_token'    => Str::random( 10 ),
                    'active'            => 1,
                ] );
                UserMeta::create( [
                    'user_id' => $user->id,
                ] );
            }
        }
    }
}
