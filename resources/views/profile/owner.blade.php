@extends('layouts.app')

@section('title', 'Личный кабинет арендодателя - CarRental')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-cyan-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Заголовок профиля -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-8 mb-8">
                <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-6 lg:space-y-0 lg:space-x-8">
                    <!-- Аватар и основная информация -->
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-xl">
                            <span class="text-white text-3xl font-bold">{{ substr($client->name, 0, 1) }}</span>
                        </div>
                        <div class="text-center sm:text-left">
                            <div
                                class="flex flex-col sm:flex-row items-center sm:items-start space-y-2 sm:space-y-0 sm:space-x-3 mb-2">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $client->name }}</h1>
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-xl bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 font-semibold">
                                    <i class="fas fa-car mr-2"></i>Арендодатель
                                </span>
                            </div>
                            <p class="text-gray-600 mb-2 flex items-center justify-center sm:justify-start">
                                <i class="fas fa-envelope mr-2 text-blue-500"></i>
                                {{ $client->email }}
                            </p>
                            @if ($client->telegram_nickname)
                                <p class="text-blue-600 flex items-center justify-center sm:justify-start">
                                    <i class="fab fa-telegram mr-2"></i>
                                    {{ $client->telegram_nickname }}
                                </p>
                            @endif
                            <p class="text-gray-500 flex items-center justify-center sm:justify-start">
                                <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>
                                {{ $client->city->name }}
                            </p>
                        </div>
                    </div>

                    <!-- Статус и рейтинг -->
                    <div class="flex flex-col items-center lg:items-end space-y-4">
                        <div class="flex items-center space-x-6">
                            <div class="text-center">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-star text-yellow-400 mr-2"></i>
                                    <span
                                        class="text-2xl font-bold text-gray-900">{{ number_format($client->rating, 1) }}</span>
                                </div>
                                <p class="text-sm text-gray-600">Рейтинг</p>
                            </div>
                            <div class="text-center">
                                @if ($client->is_verified)
                                    <div
                                        class="inline-flex items-center px-4 py-2 rounded-xl bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 font-semibold">
                                        <i class="fas fa-check-circle mr-2"></i>Верифицирован
                                    </div>
                                @else
                                    <div
                                        class="inline-flex items-center px-4 py-2 rounded-xl bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 font-semibold">
                                        <i class="fas fa-clock mr-2"></i>Ожидает верификации
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Действия -->
                <div class="mt-8 flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('profile.edit') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                        <i class="fas fa-edit mr-2"></i>Редактировать профиль
                    </a>
                    <a href="{{ route('cars.create') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-xl hover:from-green-600 hover:to-emerald-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                        <i class="fas fa-plus mr-2"></i>Добавить автомобиль
                    </a>
                    <a href="{{ route('profile.deals') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                        <i class="fas fa-handshake mr-2"></i>Управление сделками
                    </a>
                </div>
            </div>

            <!-- Статистика арендодателя -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-car text-xl text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Мои автомобили</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $myCars->count() }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-handshake text-xl text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Активные сделки</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $myDeals->where('status', 'active')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-money-bill-wave text-xl text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Заработано</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($earnings) }} ₽</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-star text-xl text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Отзывы</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $myReviews->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Основной контент -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Мои автомобили -->
                <div class="lg:col-span-2">
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-6 py-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-bold text-white flex items-center">
                                    <i class="fas fa-car mr-3"></i>Мои автомобили
                                </h2>
                                <a href="{{ route('profile.cars') }}"
                                    class="text-blue-100 hover:text-white text-sm font-medium transition-colors duration-300">
                                    Управление автомобилями
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($myCars->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($myCars->take(3) as $car)
                                        <div
                                            class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 hover:shadow-lg transition-all duration-300 border border-gray-200/50">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                                                        <i class="fas fa-car text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-gray-900">{{ $car->brand }}
                                                            {{ $car->model }}</h3>
                                                        <p class="text-sm text-gray-600 flex items-center">
                                                            <i class="fas fa-calendar mr-1 text-blue-500"></i>
                                                            {{ $car->year }} • {{ $car->fuel_type->value }}
                                                        </p>
                                                        <div class="flex items-center space-x-2 mt-2">
                                                            @if ($car->is_available)
                                                                <span
                                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800">
                                                                    <i class="fas fa-check mr-1"></i>Доступен
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-red-100 to-pink-100 text-red-800">
                                                                    <i class="fas fa-times mr-1"></i>Занят
                                                                </span>
                                                            @endif
                                                            @if ($car->is_promoted)
                                                                <span
                                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800">
                                                                    <i class="fas fa-star mr-1"></i>Топ
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <p class="font-bold text-blue-600 text-lg">
                                                        {{ number_format($car->price_per_day) }} ₽</p>
                                                    <p class="text-sm text-gray-500">за сутки</p>
                                                    <a href="{{ route('cars.edit', $car->id) }}"
                                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                                        Редактировать
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fas fa-car text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-700 mb-4">У вас пока нет автомобилей</h3>
                                    <p class="text-gray-500 mb-6">Добавьте свой первый автомобиль и начните зарабатывать на
                                        аренде</p>
                                    <a href="{{ route('cars.create') }}"
                                        class="inline-flex items-center bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                                        <i class="fas fa-plus mr-2"></i>Добавить первый автомобиль
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Последние сделки -->
                <div class="lg:col-span-1">
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-bold text-white flex items-center">
                                    <i class="fas fa-handshake mr-3"></i>Последние сделки
                                </h2>
                                <a href="{{ route('profile.deals') }}"
                                    class="text-green-100 hover:text-white text-sm font-medium transition-colors duration-300">
                                    Все сделки
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($myDeals->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($myDeals->take(3) as $deal)
                                        <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $deal->car->brand }}
                                                        {{ $deal->car->model }}</p>
                                                    <p class="text-sm text-gray-600 flex items-center">
                                                        <i class="fas fa-user mr-1 text-green-500"></i>
                                                        {{ $deal->renter->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 flex items-center">
                                                        <i class="fas fa-calendar mr-1 text-blue-500"></i>
                                                        {{ $deal->start_date->format('d.m.Y') }} -
                                                        {{ $deal->end_date->format('d.m.Y') }}
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                        @if ($deal->status->value === 'completed') bg-gradient-to-r from-green-100 to-emerald-100 text-green-800
                                                        @elseif($deal->status->value === 'active') bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800
                                                        @else bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 @endif">
                                                        @if ($deal->status->value === 'completed')
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                        @elseif($deal->status->value === 'active')
                                                            <i class="fas fa-clock mr-1"></i>
                                                        @else
                                                            <i class="fas fa-hourglass-half mr-1"></i>
                                                        @endif
                                                        {{ $deal->status->value }}
                                                    </span>
                                                    <p class="text-sm font-bold text-gray-900 mt-2">
                                                        {{ number_format($deal->total_price) }} ₽</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fas fa-handshake text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-700 mb-4">Пока нет сделок</h3>
                                    <p class="text-gray-500">Когда появятся сделки, они отобразятся здесь</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Быстрые действия -->
                    <div class="mt-6 bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                            Быстрые действия
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('chat.index') }}"
                                class="flex items-center p-3 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl hover:from-blue-100 hover:to-cyan-100 transition-all duration-300">
                                <i class="fas fa-comments text-blue-500 mr-3"></i>
                                <span class="font-medium text-gray-700">Чаты</span>
                            </a>
                            <a href="{{ route('disputes.index') }}"
                                class="flex items-center p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-xl hover:from-orange-100 hover:to-red-100 transition-all duration-300">
                                <i class="fas fa-exclamation-triangle text-orange-500 mr-3"></i>
                                <span class="font-medium text-gray-700">Споры</span>
                            </a>
                            <a href="{{ route('profile.reviews') }}"
                                class="flex items-center p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl hover:from-yellow-100 hover:to-orange-100 transition-all duration-300">
                                <i class="fas fa-star text-yellow-500 mr-3"></i>
                                <span class="font-medium text-gray-700">Отзывы</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
