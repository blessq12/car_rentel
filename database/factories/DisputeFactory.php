<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ConversationMessage;
use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dispute>
 */
class DisputeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $disputeTypes = [
            'Повреждение автомобиля',
            'Неоплата аренды',
            'Нарушение условий договора',
            'Проблемы с техническим состоянием',
            'Конфликт при передаче автомобиля',
            'Нарушение сроков аренды',
            'Проблемы с документами',
            'Несогласованное использование'
        ];

        $disputeDescriptions = [
            'Обнаружены повреждения, не указанные в договоре.',
            'Арендатор не оплатил полную стоимость аренды.',
            'Нарушены условия использования автомобиля.',
            'Технические неисправности, влияющие на безопасность.',
            'Конфликт при передаче автомобиля между сторонами.',
            'Арендатор превысил оговоренные сроки аренды.',
            'Проблемы с оформлением необходимых документов.',
            'Использование автомобиля не по назначению.'
        ];

        return [
            'deal_id' => Deal::factory(),
            'initiator_id' => Client::factory(),
            'respondent_id' => Client::factory(),
            'type' => fake()->randomElement($disputeTypes),
            'description' => fake()->randomElement($disputeDescriptions),
            'status' => fake()->randomElement(['open', 'in_progress', 'resolved', 'closed']),
            'resolution' => fake()->optional(0.4, null)->sentence(),
            'evidence_path' => fake()->optional(0.6, null)->filePath(),
            'metadata' => json_encode([
                'created_at' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
                'admin_notes' => fake()->optional(0.3, null)->sentence(),
            ]),
        ];
    }

    /**
     * Indicate that the dispute is open.
     */
    public function open(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'open',
        ]);
    }

    /**
     * Indicate that the dispute is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'in_progress',
        ]);
    }

    /**
     * Indicate that the dispute is resolved.
     */
    public function resolved(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'resolved',
            'resolution' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the dispute is closed.
     */
    public function closed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'closed',
            'resolution' => fake()->sentence(),
        ]);
    }

    /**
     * Создать диспут с сообщениями
     */
    public function withMessages(int $count = 3): static
    {
        return $this->afterCreating(function ($dispute) use ($count) {
            // Создаем системное сообщение об открытии спора
            ConversationMessage::factory()
                ->forDispute($dispute)
                ->system()
                ->create([
                    'content' => "Открыт спор: {$dispute->type}",
                ]);

            // Создаем сообщения от участников спора
            for ($i = 0; $i < $count; $i++) {
                $messageType = fake()->randomElement(['text', 'file']);
                $senderId = fake()->randomElement([$dispute->initiator_id, $dispute->respondent_id]);

                $message = ConversationMessage::factory()
                    ->forDispute($dispute)
                    ->$messageType()
                    ->create([
                        'sender_id' => $senderId,
                        'content' => $this->getDisputeMessageContent($dispute->type, $messageType),
                        'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
                    ]);
            }

            // Если диспут решен, добавляем системное сообщение
            if (in_array($dispute->status, ['resolved', 'closed'])) {
                ConversationMessage::factory()
                    ->forDispute($dispute)
                    ->system()
                    ->create([
                        'content' => "Спор решен: {$dispute->resolution}",
                        'created_at' => fake()->dateTimeBetween('-1 week', 'now'),
                    ]);
            }
        });
    }

    /**
     * Получить контент сообщения для спора
     */
    private function getDisputeMessageContent(string $disputeType, string $messageType): string
    {
        if ($messageType === 'file') {
            return 'Документ по спору';
        }

        $messages = [
            'Повреждение автомобиля' => [
                'Предоставляю фотографии повреждений',
                'Эти повреждения были до аренды',
                'Требую компенсации за ущерб',
                'Готов обсудить компромиссное решение'
            ],
            'Неоплата аренды' => [
                'Оплата не поступила в срок',
                'У меня технические проблемы с картой',
                'Деньги списались, проверьте',
                'Перенесу оплату на завтра'
            ],
            'Нарушение условий договора' => [
                'Условия договора нарушены',
                'Я не нарушал никаких условий',
                'Предоставлю доказательства',
                'Готов исправить ситуацию'
            ],
            'Проблемы с техническим состоянием' => [
                'Автомобиль не заводится',
                'Проблемы с тормозами',
                'Проверю техническое состояние',
                'Вызвал эвакуатор'
            ]
        ];

        $defaultMessages = [
            'Предоставляю доказательства',
            'Готов обсудить решение',
            'Требую разбирательства',
            'Согласен на компромисс'
        ];

        $typeMessages = $messages[$disputeType] ?? $defaultMessages;
        return fake()->randomElement($typeMessages);
    }

    /**
     * Создать открытый диспут с сообщениями
     */
    public function openWithMessages(int $count = 5): static
    {
        return $this->open()->withMessages($count);
    }

    /**
     * Создать решенный диспут с сообщениями
     */
    public function resolvedWithMessages(int $count = 8): static
    {
        return $this->resolved()->withMessages($count);
    }
}
