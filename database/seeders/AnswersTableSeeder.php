<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AnswersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $teams = Team::all(); // Get all teams

        foreach ($teams as $team) {
            $trainings = Training::where('team_code', $team->team_code)->get();
            $users = User::where('team_code', $team->team_code)->get();

            // Check if team code is even or odd
            $isEven = ((int) $team->team_code % 2 === 0);

            foreach ($trainings as $training) {
                foreach ($users as $user) {
                    // Different values for even and odd teams
                    if ($isEven) {
                        // Values for even teams
                        $pain = rand(0, 2);
                        $sleep = rand(8, 10);
                        $moral = rand(8, 10);
                        $physical = rand(8, 10);
                        $recovery = rand(8, 10);
                        $load = rand(3, 5);
                    } else {
                        // Values for odd teams
                        $pain = rand(5, 10);
                        $sleep = rand(3, 7);
                        $moral = rand(2, 7);
                        $physical = rand(3, 7);
                        $recovery = rand(4, 10);
                        $load = rand(5, 10);
                    }

                    Question::create([
                        'user_id'           => $user->id,
                        'team_code'         => $user->team_code,
                        'pain'              => $pain,
                        'sleep'             => $sleep,
                        'sleep_time'        => '23:00',
                        'moral'             => $moral,
                        'physical'          => $physical,
                        'presence_checkNum' => 1,
                        'recovery'          => $recovery,
                        'load'              => $load,
                        'created_at'        => $training->date,
                    ]);
                }
            }
        }
    }

}
