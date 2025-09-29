<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::factory()
            ->count(3)
            ->sequence(fn ($sequence) => ['name' => 'Команда-' . ($sequence->index + 1), 'user_id' => 3])
            ->create();
    }
}
