@extends('layouts.app')

@section('title', 'Редактировать профиль - CarRental')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Редактировать профиль</h1>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Основная информация -->
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Имя *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email *
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telegram_nickname" class="block text-sm font-medium text-gray-700">
                                Telegram никнейм
                            </label>
                            <input type="text" id="telegram_nickname" name="telegram_nickname"
                                value="{{ old('telegram_nickname', $client->telegram_nickname) }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="@username">
                            @error('telegram_nickname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Телефон
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $client->phone) }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="+7 (999) 123-45-67">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-700">
                                Город *
                            </label>
                            <select id="city_id" name="city_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Выберите город</option>
                                @foreach (\App\Models\City::where('is_active', true)->get() as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id', $client->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Дополнительная информация -->
                    <div class="space-y-6">
                        <!-- Статус верификации -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Статус верификации</h3>
                            <div class="flex items-center space-x-3">
                                @if ($client->is_verified)
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-green-700 font-medium">Верифицирован</span>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-yellow-500 mr-2"></i>
                                        <span class="text-yellow-700 font-medium">Ожидает верификации</span>
                                    </div>
                                    <a href="{{ route('auth.telegram') }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm">
                                        Подключить Telegram
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Рейтинг -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Рейтинг</h3>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star {{ $i <= $client->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <span
                                    class="text-lg font-semibold text-gray-900">{{ number_format($client->rating, 1) }}</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">
                                {{ $client->receivedReviews->count() }} отзывов
                            </p>
                        </div>

                        <!-- Статистика споров -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Споры</h3>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-exclamation-triangle text-red-500"></i>
                                <span class="text-lg font-semibold text-gray-900">{{ $client->dispute_count }}</span>
                                <span class="text-sm text-gray-500">споров</span>
                            </div>
                            @if ($client->dispute_count >= 10)
                                <div class="mt-2 p-2 bg-red-100 border border-red-200 rounded">
                                    <p class="text-sm text-red-700">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Вы помечены как недобросовестный пользователь
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('profile.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Отмена
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
