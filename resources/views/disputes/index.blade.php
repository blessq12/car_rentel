@extends('layouts.app')

@section('title', 'Мои споры - CarRental')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-orange-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Заголовок -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1
                            class="text-3xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">
                            Мои споры
                        </h1>
                        <p class="text-gray-600 mt-2 text-lg">Управление спорными ситуациями</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('profile.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Назад в профиль
                        </a>
                        <a href="{{ route('disputes.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-xl hover:from-red-700 hover:to-orange-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Создать спор
                        </a>
                    </div>
                </div>
            </div>

            <!-- Список споров -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20">
                @if ($disputes->count() > 0)
                    <div class="overflow-x-auto">
                        <div class="min-w-full">
                            <!-- Заголовки таблицы -->
                            <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-4 border-b border-gray-200/50">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-sm font-medium text-gray-700">
                                    <div>Сделка</div>
                                    <div>Тип спора</div>
                                    <div>Статус</div>
                                    <div class="hidden md:block">Дата создания</div>
                                    <div>Действия</div>
                                </div>
                            </div>

                            <!-- Строки споров -->
                            <div class="divide-y divide-gray-200/50">
                                @foreach ($disputes as $dispute)
                                    <div class="px-6 py-4 hover:bg-red-50/30 transition-all duration-200 group">
                                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                                            <!-- Сделка -->
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    @if ($dispute->deal && $dispute->deal->car && $dispute->deal->car->images && count($dispute->deal->car->images) > 0)
                                                        <img class="h-12 w-12 rounded-xl object-cover shadow-lg"
                                                            src="{{ $dispute->deal->car->images[0] }}"
                                                            alt="{{ $dispute->deal->car->brand }} {{ $dispute->deal->car->model }}">
                                                    @else
                                                        <div
                                                            class="h-12 w-12 bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center shadow-lg">
                                                            <i class="fas fa-car text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="text-sm font-medium text-gray-900 truncate">
                                                        @if ($dispute->deal && $dispute->deal->car)
                                                            {{ $dispute->deal->car->brand }}
                                                            {{ $dispute->deal->car->model }}
                                                        @else
                                                            Сделка #{{ $dispute->deal_id }}
                                                        @endif
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        @if ($dispute->deal)
                                                            {{ $dispute->deal->start_date->format('d.m.Y') }} -
                                                            {{ $dispute->deal->end_date->format('d.m.Y') }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Тип спора -->
                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-gray-900">{{ $dispute->type }}</div>
                                                <div class="text-sm text-gray-500 truncate max-w-xs">
                                                    {{ Str::limit($dispute->description, 50) }}
                                                </div>
                                            </div>

                                            <!-- Статус -->
                                            <div>
                                                @switch($dispute->status)
                                                    @case('open')
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                                            <i class="fas fa-clock mr-1"></i>Открыт
                                                        </span>
                                                    @break

                                                    @case('in_progress')
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200 shadow-sm">
                                                            <i class="fas fa-cog mr-1"></i>В обработке
                                                        </span>
                                                    @break

                                                    @case('resolved')
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                                            <i class="fas fa-check mr-1"></i>Решен
                                                        </span>
                                                    @break

                                                    @case('closed')
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200 shadow-sm">
                                                            <i class="fas fa-times mr-1"></i>Закрыт
                                                        </span>
                                                    @break

                                                    @default
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200 shadow-sm">
                                                            {{ $dispute->status }}
                                                        </span>
                                                @endswitch
                                            </div>

                                            <!-- Дата создания -->
                                            <div class="hidden md:block text-sm text-gray-500">
                                                {{ $dispute->created_at->format('d.m.Y H:i') }}
                                            </div>

                                            <!-- Действия -->
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <a href="{{ route('disputes.show', $dispute->id) }}"
                                                    class="inline-flex items-center justify-center px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition-all duration-200 transform hover:scale-105 shadow-sm">
                                                    <i class="fas fa-eye mr-1"></i>Просмотр
                                                </a>
                                                @if ($dispute->status === 'open')
                                                    <a href="{{ route('disputes.edit', $dispute->id) }}"
                                                        class="inline-flex items-center justify-center px-3 py-1 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 transition-all duration-200 transform hover:scale-105 shadow-sm">
                                                        <i class="fas fa-edit mr-1"></i>Редактировать
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Пагинация -->
                    @if ($disputes->hasPages())
                        <div class="bg-white/50 px-6 py-4 border-t border-gray-200/50 rounded-b-2xl">
                            {{ $disputes->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-16 px-6">
                        <div
                            class="mx-auto w-24 h-24 bg-gradient-to-br from-red-100 to-orange-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-exclamation-triangle text-4xl text-red-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Нет споров</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            У вас пока нет спорных ситуаций. Это хорошо!
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
