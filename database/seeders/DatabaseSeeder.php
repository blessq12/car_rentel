<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Chat;
use App\Models\City;
use App\Models\Client;
use App\Models\Deal;
use App\Models\Dispute;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем города
        $cities = City::factory(15)->create();

        // Создаем клиентов
        $clients = Client::factory(50)->create([
            'city_id' => fn() => $cities->random()->id,
        ]);

        // Создаем автомобили
        $cars = Car::factory(100)->create([
            'client_id' => fn() => $clients->random()->id,
            'city_id' => fn() => $cities->random()->id,
        ]);

        // Создаем сделки
        $deals = Deal::factory(80)->create([
            'car_id' => fn() => $cars->random()->id,
            'client_id' => fn() => $clients->random()->id,
            'renter_id' => fn() => $clients->random()->id,
        ]);

        // Создаем чаты
        $chats = Chat::factory(60)->create([
            'deal_id' => fn() => $deals->random()->id,
            'client_id' => fn() => $clients->random()->id,
            'renter_id' => fn() => $clients->random()->id,
        ]);

        // Создаем сообщения
        Message::factory(200)->create([
            'chat_id' => fn() => $chats->random()->id,
            'sender_id' => fn() => $clients->random()->id,
        ]);

        // Создаем отзывы
        Review::factory(120)->create([
            'deal_id' => fn() => $deals->random()->id,
            'reviewer_id' => fn() => $clients->random()->id,
            'reviewed_id' => fn() => $clients->random()->id,
        ]);

        // Создаем споры
        Dispute::factory(30)->create([
            'deal_id' => fn() => $deals->random()->id,
            'initiator_id' => fn() => $clients->random()->id,
            'respondent_id' => fn() => $clients->random()->id,
        ]);

        // Создаем уведомления
        Notification::factory(150)->create([
            'notifiable_id' => fn() => $clients->random()->id,
        ]);

        // Создаем админа
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@carrental.com',
            'password' => bcrypt('password'),
        ]);

        // Создаем тестового клиента
        Client::factory()->create([
            'name' => 'Тестовый Пользователь',
            'email' => 'test@example.com',
            'telegram_nickname' => '@testuser',
            'phone' => '+7 (999) 123-45-67',
            'city_id' => $cities->first()->id,
            'rating' => 4.8,
            'is_verified' => true,
        ]);

        // Создаем несколько популярных автомобилей
        Car::factory(6)->promoted()->create([
            'client_id' => fn() => $clients->random()->id,
            'city_id' => fn() => $cities->random()->id,
        ]);

        // Создаем несколько активных сделок
        Deal::factory(10)->active()->create([
            'car_id' => fn() => $cars->random()->id,
            'client_id' => fn() => $clients->random()->id,
            'renter_id' => fn() => $clients->random()->id,
        ]);

        // Создаем несколько непрочитанных уведомлений
        Notification::factory(20)->unread()->create([
            'notifiable_id' => fn() => $clients->random()->id,
        ]);

        // Создаем несколько открытых споров
        Dispute::factory(5)->open()->create([
            'deal_id' => fn() => $deals->random()->id,
            'initiator_id' => fn() => $clients->random()->id,
            'respondent_id' => fn() => $clients->random()->id,
        ]);
    }
}
