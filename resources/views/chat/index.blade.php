@extends('layouts.app')

@section('title', 'Мои чаты - CarRental')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Заголовок -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Мои чаты</h1>
                    <p class="text-gray-600 mt-2">Общение с арендодателями и арендаторами</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('profile.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Назад в профиль
                    </a>
                </div>
            </div>
        </div>

        <!-- Список чатов -->
        <div class="bg-white rounded-lg shadow-md">
            @if ($chats->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach ($chats as $chat)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <!-- Аватар собеседника -->
                                    <div class="flex-shrink-0">
                                        @if ($chat->deal && $chat->deal->car)
                                            <div
                                                class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-car text-blue-600"></i>
                                            </div>
                                        @else
                                            <div
                                                class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-gray-600"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Информация о чате -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                @if ($chat->deal && $chat->deal->car)
                                                    {{ $chat->deal->car->brand }} {{ $chat->deal->car->model }}
                                                @else
                                                    Чат #{{ $chat->id }}
                                                @endif
                                            </h3>
                                            @if ($chat->deal)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if ($chat->deal->status === \App\Enums\DealStatus::ACCEPTED) bg-green-100 text-green-800
                                                    @elseif($chat->deal->status === \App\Enums\DealStatus::COMPLETED) bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($chat->deal->status->value) }}
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-gray-500 mt-1">
                                            @if ($chat->deal)
                                                @if (auth()->check() && auth()->user()->client && auth()->user()->client->id === $chat->deal->client_id)
                                                    Арендатор: {{ $chat->deal->renter->name ?? 'Неизвестно' }}
                                                @else
                                                    Арендодатель: {{ $chat->deal->client->name ?? 'Неизвестно' }}
                                                @endif
                                            @else
                                                Участники чата
                                            @endif
                                        </p>

                                        @if ($chat->messages->count() > 0)
                                            <p class="text-sm text-gray-600 mt-2 truncate">
                                                {{ $chat->messages->last()->content }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Время последнего сообщения -->
                                    <div class="flex-shrink-0 text-right">
                                        @if ($chat->messages->count() > 0)
                                            <p class="text-sm text-gray-500">
                                                {{ $chat->messages->last()->created_at->diffForHumans() }}
                                            </p>
                                        @endif

                                        @if ($chat->messages->where('is_read', false)->where('sender_id', '!=', auth()->user()->client->id ?? 0)->count() > 0)
                                            <span
                                                class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                                {{ $chat->messages->where('is_read', false)->where('sender_id', '!=', auth()->user()->client->id ?? 0)->count() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Действия -->
                                <div class="flex items-center space-x-2 ml-4">
                                    <a href="{{ route('chat.show', $chat->id) }}"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-comments mr-2"></i>Открыть чат
                                    </a>

                                    @if ($chat->deal)
                                        <a href="{{ route('deals.show', $chat->deal->id) }}"
                                            class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                                            <i class="fas fa-eye mr-2"></i>Просмотр сделки
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Пагинация -->
                @if ($chats->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $chats->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-comments text-4xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Нет чатов</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        У вас пока нет активных чатов.
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
