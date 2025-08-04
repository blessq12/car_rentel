<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\City;
use App\Models\Car;
use App\Models\Deal;
use Illuminate\Console\Command;

class CreateTestUsers extends Command
{
    protected $signature = 'create:test-users';

    protected $description = 'Создает тестовых пользователей - клиента и арендодателя';

    public function handle()
    {
        $this->info('Создаю тестовых пользователей...');

        // Получаем или создаем город
        $city = City::firstOrCreate(
            ['name' => 'Москва'],
            ['name' => 'Москва']
        );

        // Создаем арендодателя (владелец автомобилей)
        $owner = Client::firstOrCreate(
            ['email' => 'owner@test.com'],
            [
                'name' => 'Иван Петров',
                'email' => 'owner@test.com',
                'telegram_nickname' => 'ivan_owner',
                'phone' => '+7 (999) 123-45-67',
                'city_id' => $city->id,
                'rating' => 4.8,
                'dispute_count' => 0,
                'is_verified' => true,
                'metadata' => [
                    'registration_date' => now()->subMonths(6)->toDateString(),
                    'total_earnings' => 45000,
                    'cars_owned' => 2,
                ],
            ]
        );

        // Создаем клиента (арендатор)
        $renter = Client::firstOrCreate(
            ['email' => 'renter@test.com'],
            [
                'name' => 'Анна Сидорова',
                'email' => 'renter@test.com',
                'telegram_nickname' => 'anna_renter',
                'phone' => '+7 (999) 987-65-43',
                'city_id' => $city->id,
                'rating' => 4.5,
                'dispute_count' => 1,
                'is_verified' => true,
                'metadata' => [
                    'registration_date' => now()->subMonths(3)->toDateString(),
                    'total_rentals' => 5,
                    'preferred_car_type' => 'sedan',
                ],
            ]
        );

        // Создаем автомобили для арендодателя
        $car1 = Car::firstOrCreate(
            ['id' => 1],
            [
                'client_id' => $owner->id,
                'brand' => 'Toyota',
                'model' => 'Camry',
                'year' => 2020,
                'fuel_type' => 'gasoline',
                'transmission' => 'automatic',
                'price_per_day' => 2500,
                'description' => 'Отличный автомобиль для поездок по городу и за город. Кондиционер, подогрев сидений, парктроники.',
                'is_available' => true,
                'is_promoted' => true,
                'photos' => ['/images/cars/camry1.jpg', '/images/cars/camry2.jpg'],
                'metadata' => [
                    'mileage' => 45000,
                    'color' => 'белый',
                    'features' => ['кондиционер', 'подогрев сидений', 'парктроники'],
                ],
            ]
        );

        $car2 = Car::firstOrCreate(
            ['id' => 2],
            [
                'client_id' => $owner->id,
                'brand' => 'Honda',
                'model' => 'CR-V',
                'year' => 2019,
                'fuel_type' => 'gasoline',
                'transmission' => 'automatic',
                'price_per_day' => 3000,
                'description' => 'Вместительный кроссовер для семьи. Полный привод, большой багажник, безопасность.',
                'is_available' => true,
                'is_promoted' => false,
                'photos' => ['/images/cars/crv1.jpg', '/images/cars/crv2.jpg'],
                'metadata' => [
                    'mileage' => 62000,
                    'color' => 'серебристый',
                    'features' => ['полный привод', 'большой багажник', 'безопасность'],
                ],
            ]
        );

        // Создаем сделку между пользователями
        $deal = Deal::firstOrCreate(
            ['id' => 1],
            [
                'client_id' => $owner->id,
                'renter_id' => $renter->id,
                'car_id' => $car1->id,
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(7),
                'total_price' => 5000,
                'status' => 'pending',
                'metadata' => [
                    'pickup_location' => 'Москва, м. Парк Победы',
                    'return_location' => 'Москва, м. Парк Победы',
                    'insurance' => true,
                ],
            ]
        );

        $this->info('✅ Тестовые пользователи созданы:');
        $this->info('👤 Арендодатель:');
        $this->info("   Email: {$owner->email}");
        $this->info("   Пароль: password");
        $this->info("   Telegram: @{$owner->telegram_nickname}");
        $this->info('');

        $this->info('👤 Арендатор:');
        $this->info("   Email: {$renter->email}");
        $this->info("   Пароль: password");
        $this->info("   Telegram: @{$renter->telegram_nickname}");
        $this->info('');

        $this->info('🚗 Создано автомобилей: ' . Car::where('client_id', $owner->id)->count());
        $this->info('📋 Создано сделок: ' . Deal::count());

        $this->warn('⚠️  Для входа используйте временную логику в AuthController');
        $this->warn('   (пока нет полноценной аутентификации)');

        return Command::SUCCESS;
    }
} 