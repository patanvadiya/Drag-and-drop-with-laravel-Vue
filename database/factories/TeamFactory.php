<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Team::class;
    public function definition(): array
    {
        $teamNames = [
            'Mumbai Indians', 'Chennai Super Kings', 'Kolkata Knight Riders', 'Delhi Capitals',
            'Royal Challengers Bangalore'
        ];

        return [
            'name' => $this->faker->randomElement($teamNames),
            'state' => $this->faker->state(),
            'country' => $this->faker->country(),
        ];
    }
}
