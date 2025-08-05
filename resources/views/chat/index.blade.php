@extends('layouts.app')

@section('title', 'Мои чаты - CarRental')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Заголовок -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1
                            class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Мои чаты
                        </h1>
                        <p class="text-gray-600 mt-2 text-lg">Общение с арендодателями и арендаторами</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('profile.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Назад в профиль
                        </a>
                    </div>
                </div>
            </div>

            <!-- Список чатов -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20">
                @if ($chats->count() > 0)
                    <div class="divide-y divide-gray-200/50">
                        @foreach ($chats as $chat)
                            <div class="p-6 hover:bg-blue-50/50 transition-all duration-200 group">
                                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-4 flex-1 min-w-0">
                                        <!-- Аватар собеседника -->
                                        <div class="flex-shrink-0">
                                            @if ($chat->deal && $chat->deal->car)
                                                <div
                                                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-200">
                                                    <i class="fas fa-car text-white text-xl"></i>
                                                </div>
                                            @else
                                                <div
                                                    class="w-14 h-14 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-200">
                                                    <i class="fas fa-user text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Информация о чате -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h3 class="text-lg font-semibold text-gray-900 truncate">
                                                    @if ($chat->deal && $chat->deal->car)
                                                        {{ $chat->deal->car->brand }} {{ $chat->deal->car->model }}
                                                    @else
                                                        Чат #{{ $chat->id }}
                                                    @endif
                                                </h3>
                                                @if ($chat->deal)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm
                                                        @if ($chat->deal->status === \App\Enums\DealStatus::ACCEPTED) bg-green-100 text-green-800 border border-green-200
                                                        @elseif($chat->deal->status === \App\Enums\DealStatus::COMPLETED) bg-blue-100 text-blue-800 border border-blue-200
                                                        @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                                        {{ ucfirst($chat->deal->status->value) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="text-sm text-gray-600 mb-2">
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
                                                <p class="text-sm text-gray-500 truncate max-w-md">
                                                    {{ $chat->messages->last()->content }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Время и уведомления -->
                                        <div class="flex-shrink-0 text-right">
                                            @if ($chat->messages->count() > 0)
                                                <p class="text-sm text-gray-500 mb-2">
                                                    {{ $chat->messages->last()->created_at->diffForHumans() }}
                                                </p>
                                            @endif

                                            @if ($chat->messages->where('is_read', false)->where('sender_id', '!=', auth()->user()->client->id ?? 0)->count() > 0)
                                                <span
                                                    class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full shadow-lg animate-pulse">
                                                    {{ $chat->messages->where('is_read', false)->where('sender_id', '!=', auth()->user()->client->id ?? 0)->count() }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Действия -->
                                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                        <a href="{{ route('chat.show', $chat->id) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                            <i class="fas fa-comments mr-2"></i>Открыть чат
                                        </a>

                                        @if ($chat->deal)
                                            <a href="{{ route('deals.show', $chat->deal->id) }}"
                                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
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
                        <div class="bg-white/50 px-6 py-4 border-t border-gray-200/50 rounded-b-2xl">
                            {{ $chats->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-16 px-6">
                        <div
                            class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-comments text-4xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Нет чатов</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            У вас пока нет активных чатов. Начните общение, найдя подходящий автомобиль.
                        </p>
                        <a href="{{ route('catalog') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-search mr-2"></i>Найти автомобиль
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
