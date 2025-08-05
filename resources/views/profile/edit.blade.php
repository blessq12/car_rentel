@extends('layouts.app')

@section('title', 'Редактировать профиль - CarRental')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Заголовок -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1
                            class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            Редактировать профиль
                        </h1>
                        <p class="text-gray-600 mt-2 text-lg">Обновите свои личные данные</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('profile.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Назад в профиль
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Основная форма -->
                <div class="lg:col-span-2">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Основная информация -->
                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-3">
                                            Имя *
                                        </label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $client->name) }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Введите ваше имя">
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-3">
                                            Email *
                                        </label>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email', $client->email) }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                            placeholder="example@email.com">
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="telegram_nickname" class="block text-sm font-medium text-gray-700 mb-3">
                                            Telegram никнейм
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fab fa-telegram text-gray-400"></i>
                                            </div>
                                            <input type="text" id="telegram_nickname" name="telegram_nickname"
                                                value="{{ old('telegram_nickname', $client->telegram_nickname) }}"
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="@username">
                                        </div>
                                        @error('telegram_nickname')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Дополнительная информация -->
                                <div class="space-y-6">
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-3">
                                            Телефон
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-phone text-gray-400"></i>
                                            </div>
                                            <input type="tel" id="phone" name="phone"
                                                value="{{ old('phone', $client->phone) }}"
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                                placeholder="+7 (999) 123-45-67">
                                        </div>
                                        @error('phone')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="city_id" class="block text-sm font-medium text-gray-700 mb-3">
                                            Город *
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                                            </div>
                                            <select id="city_id" name="city_id" required
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 appearance-none">
                                                <option value="">Выберите город</option>
                                                @foreach (\App\Models\City::where('is_active', true)->get() as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ old('city_id', $client->city_id) == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400"></i>
                                            </div>
                                        </div>
                                        @error('city_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="mt-8 flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-200/50">
                                <a href="{{ route('profile.index') }}"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    Отмена
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-save mr-2"></i>Сохранить изменения
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Боковая панель с информацией -->
                <div class="space-y-6">
                    <!-- Статус верификации -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-purple-100 to-pink-100 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-purple-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Статус верификации</h3>
                        </div>

                        @if ($client->is_verified)
                            <div class="flex items-center p-4 bg-green-50 rounded-xl border border-green-200">
                                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                <div>
                                    <span class="text-green-700 font-medium">Верифицирован</span>
                                    <p class="text-sm text-green-600">Ваш аккаунт подтвержден</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                                <i class="fas fa-clock text-yellow-500 text-xl mr-3"></i>
                                <div>
                                    <span class="text-yellow-700 font-medium">Ожидает верификации</span>
                                    <p class="text-sm text-yellow-600">Подключите Telegram для верификации</p>
                                </div>
                            </div>
                            <a href="{{ route('auth.telegram') }}"
                                class="mt-3 inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fab fa-telegram mr-2"></i>Подключить Telegram
                            </a>
                        @endif
                    </div>

                    <!-- Рейтинг -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-star text-yellow-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Рейтинг</h3>
                        </div>

                        <div class="flex items-center space-x-3 mb-3">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fas fa-star text-xl {{ $i <= $client->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($client->rating, 1) }}</span>
                        </div>
                        <p class="text-sm text-gray-500">
                            {{ $client->receivedReviews->count() }} отзывов
                        </p>
                    </div>

                    <!-- Статистика споров -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-red-100 to-pink-100 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Споры</h3>
                        </div>

                        <div class="flex items-center space-x-3 mb-3">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                            <span class="text-2xl font-bold text-gray-900">{{ $client->dispute_count }}</span>
                            <span class="text-sm text-gray-500">споров</span>
                        </div>

                        @if ($client->dispute_count >= 10)
                            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                                    <p class="text-sm text-red-700 font-medium">
                                        Вы помечены как недобросовестный пользователь
                                    </p>
                                </div>
                            </div>
                        @elseif ($client->dispute_count > 0)
                            <p class="text-sm text-gray-500">
                                {{ $client->dispute_count }} из 10 споров
                            </p>
                        @else
                            <p class="text-sm text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                Споров нет
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
