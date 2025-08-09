<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Client;
use App\Models\ConversationMessage;
use App\Models\Dispute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConversationMessage>
 */
class ConversationMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $conversationTypes = [Chat::class, Dispute::class];
        $conversationType = $this->faker->randomElement($conversationTypes);

        return [
            'conversation_type' => $conversationType,
            'conversation_id' => $conversationType::factory(),
            'sender_id' => Client::factory(),
            'type' => $this->faker->randomElement(['text', 'photo', 'video', 'file', 'system']),
            'content' => $this->faker->paragraph(),
            'media_path' => null,
            'is_read' => $this->faker->boolean(80),
            'metadata' => null,
        ];
    }

    /**
     * Сообщение для чата
     */
    public function forChat(Chat $chat): static
    {
        return $this->state(fn(array $attributes) => [
            'conversation_type' => Chat::class,
            'conversation_id' => $chat->id,
        ]);
    }

    /**
     * Сообщение для спора
     */
    public function forDispute(Dispute $dispute): static
    {
        return $this->state(fn(array $attributes) => [
            'conversation_type' => Dispute::class,
            'conversation_id' => $dispute->id,
        ]);
    }

    /**
     * Текстовое сообщение
     */
    public function text(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'text',
            'content' => $this->faker->paragraph(),
        ]);
    }

    /**
     * Фото сообщение
     */
    public function photo(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'photo',
            'content' => 'Фото автомобиля',
            'media_path' => 'conversation-messages/media/photo-' . $this->faker->numberBetween(1, 10) . '.jpg',
        ]);
    }

    /**
     * Видео сообщение
     */
    public function video(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'video',
            'content' => 'Видео обзор автомобиля',
            'media_path' => 'conversation-messages/media/video-' . $this->faker->numberBetween(1, 5) . '.mp4',
        ]);
    }

    /**
     * Файл сообщение
     */
    public function file(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'file',
            'content' => 'Документ по сделке',
            'media_path' => 'conversation-messages/media/document-' . $this->faker->numberBetween(1, 3) . '.pdf',
        ]);
    }

    /**
     * Системное сообщение
     */
    public function system(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'system',
            'content' => $this->faker->randomElement([
                'Сделка создана',
                'Сделка подтверждена',
                'Сделка завершена',
                'Спор открыт',
                'Спор решен',
                'Платеж получен',
                'Автомобиль забронирован',
            ]),
            'sender_id' => Client::factory(),
        ]);
    }

    /**
     * Непрочитанное сообщение
     */
    public function unread(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_read' => false,
        ]);
    }

    /**
     * Прочитанное сообщение
     */
    public function read(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_read' => true,
        ]);
    }
}
