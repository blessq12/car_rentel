<?php

namespace Database\Factories;

use App\Enums\MessageType;
use App\Models\Chat;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messages = [
            'Привет! Интересует аренда вашего автомобиля. Какие даты свободны?',
            'Здравствуйте! Хотел бы уточнить детали по аренде.',
            'Добрый день! Можно ли посмотреть автомобиль лично?',
            'Спасибо за информацию! Когда можно забрать машину?',
            'Отличный автомобиль! Готов заключить договор.',
            'Уточните, пожалуйста, стоимость страховки.',
            'Договорились! Жду подтверждения брони.',
            'Спасибо за аренду! Все прошло отлично.',
            'Есть ли возможность продлить аренду?',
            'Машина в отличном состоянии, рекомендую!'
        ];

        return [
            'chat_id' => Chat::factory(),
            'sender_id' => Client::factory(),
            'type' => fake()->randomElement(MessageType::cases()),
            'content' => fake()->randomElement($messages),
            'is_read' => fake()->boolean(80),
            'metadata' => json_encode([
                'attachments' => fake()->optional(0.3, [])->randomElements(['photo.jpg', 'video.mp4'], fake()->numberBetween(0, 2)),
                'delivered_at' => fake()->optional(0.9, null)->dateTimeBetween('-1 hour', 'now')?->format('Y-m-d H:i:s'),
                'read_at' => fake()->optional(0.7, null)->dateTimeBetween('-30 minutes', 'now')?->format('Y-m-d H:i:s'),
            ]),
        ];
    }

    /**
     * Indicate that the message is read.
     */
    public function read(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_read' => true,
        ]);
    }

    /**
     * Indicate that the message is unread.
     */
    public function unread(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_read' => false,
        ]);
    }

    /**
     * Indicate that the message is a text message.
     */
    public function text(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => MessageType::TEXT,
        ]);
    }

    /**
     * Indicate that the message is a photo.
     */
    public function photo(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => MessageType::PHOTO,
            'content' => 'photo.jpg',
        ]);
    }

    /**
     * Indicate that the message is a video.
     */
    public function video(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => MessageType::VIDEO,
            'content' => 'video.mp4',
        ]);
    }
}
