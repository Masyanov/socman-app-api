<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{

    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'team_code' => rand(100, 999).'-'.rand(100, 999),
            'name' => fake()->word,
        ];
    }

}
