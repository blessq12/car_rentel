<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deal_id' => Deal::factory(),
            'client_id' => Client::factory(),
            'renter_id' => Client::factory(),
            'is_active' => fake()->boolean(90),
            'metadata' => json_encode([
                'last_activity' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
                'unread_count' => fake()->numberBetween(0, 10),
            ]),
        ];
    }

    /**
     * Indicate that the chat is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the chat is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
