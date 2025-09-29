<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrainingsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $teams    = Team::all();
        $now      = Carbon::now();
        $lastWeek = $now->subWeek();
        $coach    = User::query()
                        ->where( 'role', 'coach' )
                        ->first();

        foreach ( $teams as $team ) {
            for ( $i = 0; $i < 10; $i ++ ) {
                $randomDate = $lastWeek->copy()->addDays( rand( 0, 7 ) );
                Training::create( [
                    'user_id'   => $coach->id,
                    'team_code' => $team->team_code,
                    'date'      => $randomDate,
                    'start'     => '15:00:00',
                    'finish'    => '16:00:00',
                    'class'     => 'игровая',
                    'notified'    => 0,
                    'active'    => 1,
                ] );
            }
        }
    }
}
