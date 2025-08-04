<?php

namespace Database\Factories;

use App\Enums\DealStatus;
use App\Models\Car;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+3 months');

        return [
            'car_id' => Car::factory(),
            'client_id' => Client::factory(),
            'renter_id' => Client::factory(),
            'status' => fake()->randomElement(DealStatus::cases()),
            'contract_path' => fake()->optional(0.8)->filePath(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'metadata' => json_encode([
                'total_price' => fake()->numberBetween(5000, 50000),
                'deposit' => fake()->numberBetween(1000, 10000),
                'notes' => fake()->optional(0.6)->sentence(),
            ]),
        ];
    }

    /**
     * Indicate that the deal is pending.
     */
    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => DealStatus::PENDING,
        ]);
    }

    /**
     * Indicate that the deal is accepted.
     */
    public function accepted(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => DealStatus::ACCEPTED,
        ]);
    }

    /**
     * Indicate that the deal is completed.
     */
    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => DealStatus::COMPLETED,
        ]);
    }

    /**
     * Indicate that the deal is canceled.
     */
    public function canceled(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => DealStatus::CANCELED,
        ]);
    }

    /**
     * Indicate that the deal is active (accepted).
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => DealStatus::ACCEPTED,
            'start_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'end_date' => fake()->dateTimeBetween('now', '+2 months'),
        ]);
    }
}
