@extends('layouts.app')

@section('title', $car->brand . ' ' . $car->model . ' - CarRental')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Основная информация -->
            <div class="lg:col-span-2">
                <!-- Фотографии -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="h-96 bg-gray-200 rounded-t-lg flex items-center justify-center">
                        <i class="fas fa-car text-6xl text-gray-400"></i>
                    </div>
                    <!-- Миниатюры -->
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex space-x-2">
                            @for ($i = 0; $i < 4; $i++)
                                <div
                                    class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-300 transition-colors">
                                    <i class="fas fa-car text-gray-400"></i>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Характеристики -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Характеристики автомобиля</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Марка</p>
                            <p class="font-medium">{{ $car->brand }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Модель</p>
                            <p class="font-medium">{{ $car->model }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Год выпуска</p>
                            <p class="font-medium">{{ $car->year }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Тип топлива</p>
                            <p class="font-medium">{{ $car->fuel_type->value }}</p>
                        </div>
                        @if (isset($car->metadata['transmission']))
                            <div>
                                <p class="text-sm text-gray-500">Коробка передач</p>
                                <p class="font-medium">
                                    {{ $car->metadata['transmission'] == 'manual' ? 'Механика' : 'Автомат' }}</p>
                            </div>
                        @endif
                        @if (isset($car->metadata['engine_size']))
                            <div>
                                <p class="text-sm text-gray-500">Объем двигателя</p>
                                <p class="font-medium">{{ $car->metadata['engine_size'] }} л</p>
                            </div>
                        @endif
                        @if (isset($car->metadata['mileage']))
                            <div>
                                <p class="text-sm text-gray-500">Пробег</p>
                                <p class="font-medium">{{ number_format($car->metadata['mileage']) }} км</p>
                            </div>
                        @endif
                        @if (isset($car->metadata['color']))
                            <div>
                                <p class="text-sm text-gray-500">Цвет</p>
                                <p class="font-medium">{{ $car->metadata['color'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Описание -->
                @if (isset($car->metadata['description']))
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Описание</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $car->metadata['description'] }}</p>
                    </div>
                @endif

                <!-- Отзывы о владельце -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Отзывы о владельце</h2>
                    <div class="flex items-center mb-4">
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <i
                                    class="fas fa-star {{ $i <= $car->client->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                        <span class="ml-2 text-lg font-semibold">{{ number_format($car->client->rating, 1) }}</span>
                        <span class="ml-2 text-gray-500">({{ $car->client->receivedReviews->count() }} отзывов)</span>
                    </div>

                    @if ($car->client->receivedReviews->count() > 0)
                        <div class="space-y-4">
                            @foreach ($car->client->receivedReviews->take(3) as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                    <div class="flex items-center mb-2">
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                        <span
                                            class="ml-2 text-sm text-gray-500">{{ $review->created_at->format('d.m.Y') }}</span>
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Пока нет отзывов</p>
                    @endif
                </div>
            </div>

            <!-- Боковая панель -->
            <div class="lg:col-span-1">
                <!-- Цена и действия -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-3xl font-bold text-blue-600">{{ number_format($car->price_per_day) }} ₽</p>
                            <p class="text-gray-500">за сутки</p>
                        </div>
                        @if ($car->is_promoted)
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Топ</span>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-comment mr-2"></i>Написать владельцу
                        </button>
                        <button
                            class="w-full border border-blue-600 text-blue-600 py-3 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-heart mr-2"></i>Добавить в избранное
                        </button>
                        <button
                            class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-share mr-2"></i>Поделиться
                        </button>
                    </div>

                    <!-- Информация о владельце -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="font-medium text-gray-900 mb-3">Владелец</h3>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm font-medium">{{ substr($car->client->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $car->client->name }}</p>
                                <p class="text-sm text-gray-500">{{ $car->city->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center mt-2">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fas fa-star {{ $i <= $car->client->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">{{ number_format($car->client->rating, 1) }}</span>
                        </div>
                        @if ($car->client->is_verified)
                            <div class="flex items-center mt-2">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                <span class="text-sm text-green-600">Верифицирован</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Дополнительная информация -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-medium text-gray-900 mb-4">Дополнительная информация</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Город</span>
                            <span class="font-medium">{{ $car->city->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Дата публикации</span>
                            <span class="font-medium">{{ $car->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Просмотры</span>
                            <span class="font-medium">{{ rand(10, 500) }}</span>
                        </div>
                        @if ($car->client->dispute_count > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Споры</span>
                                <span class="font-medium text-red-600">{{ $car->client->dispute_count }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Похожие автомобили -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Похожие автомобили</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach (\App\Models\Car::where('brand', $car->brand)->where('id', '!=', $car->id)->take(3)->get() as $similarCar)
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-car text-4xl text-gray-400"></i>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900">{{ $similarCar->brand }} {{ $similarCar->model }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ $similarCar->year }} • {{ $similarCar->fuel_type->value }}</p>
                    <p class="text-gray-600 text-sm mb-3">{{ $similarCar->city->name }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-blue-600">{{ number_format($similarCar->price_per_day) }} ₽</span>
                        <a href="{{ route('cars.show', $similarCar) }}" class="text-blue-600 hover:text-blue-700 text-sm">
                            Подробнее →
                        </a>
                    </div>
                </div>
            </div>
@endforeach
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Переключение фотографий
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.w-16.h-16');
            const mainImage = document.querySelector('.h-96');

            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', function() {
                    // Убираем активный класс у всех миниатюр
                    thumbnails.forEach(t => t.classList.remove('ring-2', 'ring-blue-500'));
                    // Добавляем активный класс к текущей
                    this.classList.add('ring-2', 'ring-blue-500');

                    // Здесь можно добавить логику смены главного изображения
                    console.log('Switched to image', index + 1);
                });
            });

            // Делаем первую миниатюру активной
            if (thumbnails.length > 0) {
                thumbnails[0].classList.add('ring-2', 'ring-blue-500');
            }
        });
    </script>
@endpush
@endsection )
