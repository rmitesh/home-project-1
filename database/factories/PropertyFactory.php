<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => fake()->address(),
            'built_in' => fake()->dateTimeBetween(-10),
            'units' => fake()->randomDigit(),
            'bedrooms' => fake()->randomDigit(),
            'bathrooms' => fake()->randomDigit(),
            'garages' => fake()->randomDigit(),
            'square_foot' => fake()->randomDigit(),
        ];
    }
}
