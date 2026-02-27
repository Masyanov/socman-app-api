<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TeamSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TrainingsTableSeeder::class);
        $this->call(AnswersTableSeeder::class);
        $this->call(AchievementTypeSeeder::class);
    }
}
