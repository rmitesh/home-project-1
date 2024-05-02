<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InspectorLicense>
 */
class InspectorLicenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inspection_license' => fake()->word(),
            'driver_license' => fake()->word(),
            'driver_city_name' => fake()->word(),
            'tax_id' => fake()->word(),
        ];
    }
}
