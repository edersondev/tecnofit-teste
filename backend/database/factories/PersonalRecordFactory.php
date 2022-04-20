<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Movement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalRecord>
 */
class PersonalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'movement_id' => Movement::factory(),
            'value' => $this->faker->randomFloat(1,1,200),
            'date' => now()
        ];
    }
}
