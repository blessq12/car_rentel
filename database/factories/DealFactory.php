<?php

namespace Database\Factories;

use App\Enums\DealStatus;
use App\Enums\DealType;
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
        $dealType = fake()->randomElement(DealType::cases());

        $metadata = [
            'total_price' => fake()->numberBetween(5000, 50000),
            'daily_price' => fake()->numberBetween(1000, 5000),
            'notes' => fake()->optional(0.6)->sentence(),
        ];

        // Добавляем специфичные поля для разных типов сделок
        if ($dealType === DealType::RENTAL_WITH_DEPOSIT) {
            $metadata['deposit'] = fake()->numberBetween(1000, 10000);
        } elseif ($dealType === DealType::RENT_TO_OWN) {
            $metadata['buyout_price'] = fake()->numberBetween(100000, 500000);
        }

        return [
            'car_id' => Car::factory(),
            'client_id' => Client::factory(),
            'renter_id' => Client::factory(),
            'deal_type' => $dealType,
            'status' => fake()->randomElement(DealStatus::cases()),
            'contract_path' => fake()->optional(0.8)->filePath(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'metadata' => $metadata,
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
     * Indicate that the deal is rental without deposit.
     */
    public function rentalWithoutDeposit(): static
    {
        return $this->state(fn(array $attributes) => [
            'deal_type' => DealType::RENTAL_WITHOUT_DEPOSIT,
        ]);
    }

    /**
     * Indicate that the deal is rental with deposit.
     */
    public function rentalWithDeposit(): static
    {
        return $this->state(fn(array $attributes) => [
            'deal_type' => DealType::RENTAL_WITH_DEPOSIT,
            'metadata' => array_merge($attributes['metadata'] ?? [], [
                'deposit' => fake()->numberBetween(1000, 10000),
            ]),
        ]);
    }

    /**
     * Indicate that the deal is rent to own.
     */
    public function rentToOwn(): static
    {
        return $this->state(fn(array $attributes) => [
            'deal_type' => DealType::RENT_TO_OWN,
            'metadata' => array_merge($attributes['metadata'] ?? [], [
                'buyout_price' => fake()->numberBetween(100000, 500000),
            ]),
        ]);
    }
}
