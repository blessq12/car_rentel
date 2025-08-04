@extends('layouts.app')

@section('title', 'История аренд - CarRental')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Заголовок -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">История аренд</h1>
                    <p class="text-gray-600 mt-2">Все ваши аренды автомобилей</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('profile.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Назад в профиль
                    </a>
                    <a href="{{ route('catalog') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Найти автомобиль
                    </a>
                </div>
            </div>
        </div>

        <!-- Фильтры -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Статус:</label>
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">Все</option>
                        <option value="active">Активные</option>
                        <option value="completed">Завершенные</option>
                        <option value="cancelled">Отмененные</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Период:</label>
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <option value="">Все время</option>
                        <option value="month">Последний месяц</option>
                        <option value="quarter">Последний квартал</option>
                        <option value="year">Последний год</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Список аренд -->
        <div class="bg-white rounded-lg shadow-md">
            @if ($rentals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Автомобиль
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Период аренды
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Статус
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Сумма
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($rentals as $rental)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @if ($rental->car->images && count($rental->car->images) > 0)
                                                    <img class="h-12 w-12 rounded-lg object-cover"
                                                        src="{{ $rental->car->images[0] }}"
                                                        alt="{{ $rental->car->brand }} {{ $rental->car->model }}">
                                                @else
                                                    <div
                                                        class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-car text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $rental->car->brand }} {{ $rental->car->model }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $rental->car->year }} • {{ $rental->car->fuel_type }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($rental->start_date)->format('d.m.Y') }} -
                                            {{ \Carbon\Carbon::parse($rental->end_date)->format('d.m.Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $rental->days }} {{ trans_choice('день|дня|дней', $rental->days) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($rental->status->value)
                                            @case('accepted')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-play mr-1"></i>Активна
                                                </span>
                                            @break

                                            @case('completed')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-check mr-1"></i>Завершена
                                                </span>
                                            @break

                                            @case('canceled')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times mr-1"></i>Отменена
                                                </span>
                                            @break

                                            @default
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $rental->status->value }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ number_format($rental->total_price) }} ₽
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ number_format($rental->daily_price) }} ₽/день
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('deals.show', $rental->id) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye mr-1"></i>Просмотр
                                            </a>
                                            @if ($rental->status === \App\Enums\DealStatus::COMPLETED)
                                                <a href="{{ route('reviews.create', ['deal_id' => $rental->id]) }}"
                                                    class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-star mr-1"></i>Оставить отзыв
                                                </a>
                                            @endif
                                            @if ($rental->status === \App\Enums\DealStatus::ACCEPTED)
                                                <a href="{{ route('chat.show', $rental->chat_id ?? 0) }}"
                                                    class="text-purple-600 hover:text-purple-900">
                                                    <i class="fas fa-comments mr-1"></i>Чат
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Пагинация -->
                @if ($rentals->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $rentals->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-car text-4xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Нет аренд</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        У вас пока нет аренд автомобилей.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('catalog') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-search mr-2"></i>Найти автомобиль
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
