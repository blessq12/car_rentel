<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reviews = [
            'Отличный автомобиль и вежливый арендатор! Все прошло гладко.',
            'Машина в хорошем состоянии, рекомендую.',
            'Удобная аренда, все условия соблюдены.',
            'Быстрое оформление, приятное общение.',
            'Автомобиль соответствует описанию, доволен арендой.',
            'Профессиональный подход, все четко по договору.',
            'Хороший опыт аренды, буду обращаться еще.',
            'Машина чистая, технически исправная.',
            'Пунктуальный арендатор, все вовремя.',
            'Удобное расположение, легко забрать и вернуть.'
        ];

        return [
            'deal_id' => Deal::factory(),
            'reviewer_id' => Client::factory(),
            'reviewed_id' => Client::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->randomElement($reviews),
            'is_verified' => fake()->boolean(90),
            'metadata' => json_encode([
                'response' => fake()->optional(0.3, null)->sentence(),
                'response_date' => fake()->optional(0.3, null)->dateTimeBetween('-1 week', 'now')?->format('Y-m-d H:i:s'),
            ]),
        ];
    }

    /**
     * Indicate that the review is positive (4-5 stars).
     */
    public function positive(): static
    {
        return $this->state(fn(array $attributes) => [
            'rating' => fake()->numberBetween(4, 5),
        ]);
    }

    /**
     * Indicate that the review is negative (1-2 stars).
     */
    public function negative(): static
    {
        return $this->state(fn(array $attributes) => [
            'rating' => fake()->numberBetween(1, 2),
        ]);
    }

    /**
     * Indicate that the review is verified.
     */
    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => true,
        ]);
    }

    /**
     * Indicate that the review is not verified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => false,
        ]);
    }
}
