<?php

namespace Database\Factories;

use App\Enums\NotificationType;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messages = [
            'Новое сообщение в чате',
            'Ваша заявка на аренду одобрена',
            'Получен новый отзыв',
            'Создан новый спор по сделке',
            'Напоминание о возврате автомобиля',
            'Новое предложение аренды',
            'Обновление статуса сделки',
            'Новое уведомление от администрации'
        ];

        return [
            'notifiable_type' => Client::class,
            'notifiable_id' => Client::factory(),
            'type' => fake()->randomElement(NotificationType::cases()),
            'title' => fake()->sentence(3),
            'message' => fake()->randomElement($messages),
            'data' => json_encode([
                'deal_id' => fake()->optional(0.7, null)->numberBetween(1, 100),
                'chat_id' => fake()->optional(0.5, null)->numberBetween(1, 50),
                'car_id' => fake()->optional(0.6, null)->numberBetween(1, 200),
            ]),
            'read_at' => fake()->optional(0.6, null)->dateTimeBetween('-1 hour', 'now'),
        ];
    }

    /**
     * Indicate that the notification is read.
     */
    public function read(): static
    {
        return $this->state(fn(array $attributes) => [
            'read_at' => fake()->dateTimeBetween('-1 hour', 'now'),
        ]);
    }

    /**
     * Indicate that the notification is unread.
     */
    public function unread(): static
    {
        return $this->state(fn(array $attributes) => [
            'read_at' => null,
        ]);
    }

    /**
     * Indicate that the notification is about a deal request.
     */
    public function dealRequest(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => NotificationType::DEAL_REQUEST,
            'title' => 'Новая заявка на аренду',
            'message' => 'Получена новая заявка на аренду вашего автомобиля',
        ]);
    }

    /**
     * Indicate that the notification is about a message.
     */
    public function message(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => NotificationType::MESSAGE,
            'title' => 'Новое сообщение',
            'message' => 'Вам пришло новое сообщение в чате',
        ]);
    }

    /**
     * Indicate that the notification is about a dispute.
     */
    public function dispute(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => NotificationType::DISPUTE,
            'title' => 'Новый спор',
            'message' => 'Создан новый спор по сделке',
        ]);
    }
}
