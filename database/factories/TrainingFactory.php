<?php

namespace Database\Factories;

use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    // Specify the model that this factory is for
    protected $model = Training::class;

    public function definition()
    {
        return [
            // Ensure DB NOT NULL fields are filled
            'user_id'       => 1,
            'team_code'     => '988-988',
            'date'          => now()->addDay()->toDateString(),
            'start'         => '10:00',
            'finish'        => '11:30',
            'count_players' => $this->faker->numberBetween(6,12),
            'class'         => 'main',        // ensure not null
            'addresses'     => 'Test address',
            'desc'          => 'Test training',
            'recovery'      => 0,
            'load'          => 0,
            'link_docs'     => null,
            'active'        => 1,
        ];
    }
}
