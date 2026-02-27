<?php

namespace Database\Seeders;

use App\Models\AchievementType;
use Illuminate\Database\Seeder;

class AchievementTypeSeeder extends Seeder
{
    public function run(): void
    {
        $metrics = [
            [
                'name' => 'Голы',
                'key' => 'goals',
                'unit' => 'шт',
                'is_lower_better' => false
            ],
            [
                'name' => 'Голевые передачи',
                'key' => 'assists',
                'unit' => 'шт',
                'is_lower_better' => false
            ],
            [
                'name' => 'Спринт 30м',
                'key' => 'sprint_30',
                'unit' => 'сек',
                'is_lower_better' => true
            ],
            [
                'name' => 'Чеканка мяча',
                'key' => 'juggling',
                'unit' => 'раз',
                'is_lower_better' => false
            ],
        ];

        foreach ($metrics as $metric) {
            AchievementType::create($metric);
        }
    }
}
