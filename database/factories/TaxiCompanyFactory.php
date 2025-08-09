<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaxiCompany>
 */
class TaxiCompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyNames = [
            'Такси Экспресс',
            'Быстрое Такси',
            'Комфорт Такси',
            'Элитное Такси',
            'Городское Такси',
            'Столичное Такси',
            'Премиум Такси',
            'Классик Такси',
            'Современное Такси',
            'Надежное Такси'
        ];

        return [
            'client_id' => Client::factory(),
            'name' => fake()->randomElement($companyNames),
            'description' => fake()->paragraph(),
            'logo_path' => fake()->optional(0.8)->imageUrl(200, 200, 'business'),
            'rating' => fake()->randomFloat(2, 3.0, 5.0),
            'is_verified' => fake()->boolean(80),
            'is_active' => fake()->boolean(90),
            'metadata' => [
                'phone' => fake()->phoneNumber(),
                'website' => fake()->optional(0.6)->url(),
                'address' => fake()->address(),
                'working_hours' => '24/7',
                'fleet_size' => fake()->numberBetween(5, 100),
            ],
        ];
    }

    /**
     * Indicate that the taxi company is verified.
     */
    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => true,
        ]);
    }

    /**
     * Indicate that the taxi company is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the taxi company is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
