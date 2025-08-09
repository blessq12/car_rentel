<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Chat;
use App\Models\City;
use App\Models\Client;
use App\Models\Deal;
use App\Models\Dispute;
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
        $faker = \Faker\Factory::create();

        // Создаем города
        $cityNames = [
            'Москва',
            'Санкт-Петербург',
            'Новосибирск',
            'Екатеринбург',
            'Казань',
            'Нижний Новгород',
            'Челябинск',
            'Самара',
            'Уфа',
            'Ростов-на-Дону',
            'Краснодар',
            'Воронеж',
            'Пермь',
            'Волгоград',
            'Саратов'
        ];

        $cities = collect();
        foreach ($cityNames as $name) {
            $city = City::firstOrCreate(['name' => $name], [
                'is_active' => true,
            ]);
            $cities->push($city);
        }

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

        // Создаем чаты с сообщениями
        $chats = Chat::factory(60)->withMessages()->create([
            'deal_id' => fn() => $deals->random()->id,
            'client_id' => fn() => $clients->random()->id,
            'renter_id' => fn() => $clients->random()->id,
        ]);

        // Создаем отзывы
        Review::factory(120)->create([
            'deal_id' => fn() => $deals->random()->id,
            'reviewer_id' => fn() => $clients->random()->id,
            'reviewed_id' => fn() => $clients->random()->id,
        ]);

        // Создаем споры с сообщениями
        $disputes = Dispute::factory(30)->withMessages()->create([
            'deal_id' => fn() => $deals->random()->id,
            'initiator_id' => fn() => $clients->random()->id,
            'respondent_id' => fn() => $clients->random()->id,
        ]);

        // Создаем уведомления
        Notification::factory(150)->create([
            'notifiable_id' => fn() => $clients->random()->id,
        ]);

        // Создаем админа
        User::firstOrCreate(['email' => 'admin@carrental.com'], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
        ]);

        // Создаем тестового клиента
        Client::firstOrCreate(['email' => 'test@example.com'], [
            'name' => 'Тестовый Пользователь',
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
        Deal::factory(10)->accepted()->create([
            'car_id' => fn() => $cars->random()->id,
            'client_id' => fn() => $clients->random()->id,
            'renter_id' => fn() => $clients->random()->id,
        ]);

        // Создаем несколько непрочитанных уведомлений
        Notification::factory(20)->unread()->create([
            'notifiable_id' => fn() => $clients->random()->id,
        ]);

        // Создаем несколько открытых споров с сообщениями
        Dispute::factory(5)->openWithMessages()->create([
            'deal_id' => fn() => $deals->random()->id,
            'initiator_id' => fn() => $clients->random()->id,
            'respondent_id' => fn() => $clients->random()->id,
        ]);

        // Создаем несколько активных чатов с сообщениями
        Chat::factory(10)->activeWithMessages()->create([
            'deal_id' => fn() => $deals->random()->id,
            'client_id' => fn() => $clients->random()->id,
            'renter_id' => fn() => $clients->random()->id,
        ]);
    }
}
