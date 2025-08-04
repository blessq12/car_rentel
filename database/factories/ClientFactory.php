<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'email' => fake()->unique()->safeEmail(),
            'telegram_nickname' => fake()->optional(0.7)->userName(),
            'name' => fake()->name(),
            'phone' => fake()->optional(0.8)->phoneNumber(),
            'rating' => fake()->randomFloat(1, 3.0, 5.0),
            'dispute_count' => fake()->numberBetween(0, 5),
            'is_verified' => fake()->boolean(80),
            'referrer_id' => null,
            'metadata' => json_encode([]),
        ];
    }

    /**
     * Indicate that the client is verified.
     */
    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => true,
        ]);
    }

    /**
     * Indicate that the client is unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => false,
        ]);
    }

    /**
     * Indicate that the client has high rating.
     */
    public function highRating(): static
    {
        return $this->state(fn(array $attributes) => [
            'rating' => fake()->randomFloat(1, 4.5, 5.0),
        ]);
    }

    /**
     * Indicate that the client has many disputes.
     */
    public function problematic(): static
    {
        return $this->state(fn(array $attributes) => [
            'dispute_count' => fake()->numberBetween(10, 20),
        ]);
    }
}
