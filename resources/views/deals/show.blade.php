@extends('layouts.app')

@section('title', 'Просмотр сделки - CarRental')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Заголовок -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Сделка #{{ $deal->id }}</h1>
                    <p class="text-gray-600 mt-2">Детали аренды автомобиля</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('profile.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Назад в профиль
                    </a>
                    @if ($deal->chat)
                        <a href="{{ route('chat.show', $deal->chat->id) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-comments mr-2"></i>Чат
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Информация об автомобиле -->
        @if ($deal->car)
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Автомобиль</h2>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        @if ($deal->car->images && count($deal->car->images) > 0)
                            <img class="h-24 w-24 rounded-lg object-cover" src="{{ $deal->car->images[0] }}"
                                alt="{{ $deal->car->brand }} {{ $deal->car->model }}">
                        @else
                            <div class="h-24 w-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-car text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $deal->car->brand }} {{ $deal->car->model }}
                        </h3>
                        <p class="text-gray-600">{{ $deal->car->year }} • {{ $deal->car->fuel_type }}</p>
                        <p class="text-gray-500">{{ $deal->car->transmission }} • {{ $deal->car->engine_size }}л</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Детали сделки -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Детали сделки</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Период аренды</h3>
                    <p class="text-lg text-gray-900">
                        {{ $deal->start_date->format('d.m.Y') }} - {{ $deal->end_date->format('d.m.Y') }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $deal->days }} {{ trans_choice('день|дня|дней', $deal->days) }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Стоимость</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($deal->total_price) }} ₽</p>
                    <p class="text-sm text-gray-500">{{ number_format($deal->daily_price) }} ₽/день</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Статус</h3>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if ($deal->status === \App\Enums\DealStatus::ACCEPTED) bg-green-100 text-green-800
                        @elseif($deal->status === \App\Enums\DealStatus::COMPLETED) bg-blue-100 text-blue-800
                        @elseif($deal->status === \App\Enums\DealStatus::CANCELED) bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($deal->status->value) }}
                    </span>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Дата создания</h3>
                    <p class="text-gray-900">{{ $deal->created_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Участники сделки -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Участники сделки</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Арендодатель</h3>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold">{{ substr($deal->client->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $deal->client->name }}</p>
                            <p class="text-sm text-gray-500">{{ $deal->client->email }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Арендатор</h3>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold">{{ substr($deal->renter->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $deal->renter->name }}</p>
                            <p class="text-sm text-gray-500">{{ $deal->renter->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Действия -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Действия</h2>
            <div class="flex flex-wrap gap-4">
                @if ($deal->status === \App\Enums\DealStatus::COMPLETED)
                    <a href="{{ route('reviews.create', ['deal_id' => $deal->id]) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                        <i class="fas fa-star mr-2"></i>Оставить отзыв
                    </a>
                @endif

                @if ($deal->status === \App\Enums\DealStatus::ACCEPTED)
                    <a href="{{ route('disputes.create', ['deal_id' => $deal->id]) }}"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Создать спор
                    </a>
                @endif

                @if ($deal->chat)
                    <a href="{{ route('chat.show', $deal->chat->id) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-comments mr-2"></i>Открыть чат
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
