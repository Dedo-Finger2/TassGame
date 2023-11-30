<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Urgence>
 */
class UrgenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->numerify('Urgence nº#'),
            'description' => fake()->paragraph(2),
            'exp' => fake()->randomNumber(2),
            'coins' => fake()->randomFloat(2),
        ];
    }
}
