<?php

namespace Database\Factories;

use App\Enums\FuelType;
use App\Models\City;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = [
            'Toyota',
            'Honda',
            'Nissan',
            'Mazda',
            'Subaru',
            'BMW',
            'Mercedes-Benz',
            'Audi',
            'Volkswagen',
            'Opel',
            'Ford',
            'Chevrolet',
            'Hyundai',
            'Kia',
            'Skoda',
            'Renault',
            'Peugeot',
            'Citroen',
            'Fiat',
            'Volvo'
        ];

        $models = [
            'Camry',
            'Corolla',
            'Civic',
            'Accord',
            'Altima',
            'Sentra',
            'CX-5',
            'CX-30',
            'Impreza',
            'Forester',
            '3 Series',
            '5 Series',
            'A3',
            'A4',
            'Golf',
            'Passat',
            'Astra',
            'Cruze',
            'Elantra',
            'Rio',
            'Octavia',
            'Megane',
            '308',
            'C4',
            'Punto',
            'S60'
        ];

        return [
            'client_id' => Client::factory(),
            'city_id' => City::factory(),
            'brand' => fake()->randomElement($brands),
            'model' => fake()->randomElement($models),
            'year' => fake()->numberBetween(2010, 2024),
            'fuel_type' => fake()->randomElement(FuelType::cases()),
            'price_per_day' => fake()->numberBetween(1000, 5000),
            'is_promoted' => fake()->boolean(20),
            'is_moderated' => fake()->boolean(90),
            'metadata' => json_encode([
                'transmission' => fake()->randomElement(['manual', 'automatic']),
                'engine_size' => fake()->randomFloat(1, 1.0, 3.0),
                'mileage' => fake()->numberBetween(10000, 200000),
            ]),
        ];
    }

    /**
     * Indicate that the car is promoted.
     */
    public function promoted(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_promoted' => true,
        ]);
    }

    /**
     * Indicate that the car is not promoted.
     */
    public function notPromoted(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_promoted' => false,
        ]);
    }

    /**
     * Indicate that the car is moderated.
     */
    public function moderated(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_moderated' => true,
        ]);
    }

    /**
     * Indicate that the car is not moderated.
     */
    public function notModerated(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_moderated' => false,
        ]);
    }

    /**
     * Indicate that the car is expensive.
     */
    public function expensive(): static
    {
        return $this->state(fn(array $attributes) => [
            'price_per_day' => fake()->numberBetween(3000, 8000),
        ]);
    }

    /**
     * Indicate that the car is cheap.
     */
    public function cheap(): static
    {
        return $this->state(fn(array $attributes) => [
            'price_per_day' => fake()->numberBetween(500, 1500),
        ]);
    }
}
