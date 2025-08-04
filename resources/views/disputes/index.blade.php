@extends('layouts.app')

@section('title', 'Мои споры - CarRental')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Заголовок -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Мои споры</h1>
                    <p class="text-gray-600 mt-2">Управление спорными ситуациями</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('profile.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Назад в профиль
                    </a>
                    <a href="{{ route('disputes.create') }}"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Создать спор
                    </a>
                </div>
            </div>
        </div>

        <!-- Список споров -->
        <div class="bg-white rounded-lg shadow-md">
            @if ($disputes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Сделка
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Тип спора
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Статус
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Дата создания
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($disputes as $dispute)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @if ($dispute->deal && $dispute->deal->car && $dispute->deal->car->images && count($dispute->deal->car->images) > 0)
                                                    <img class="h-12 w-12 rounded-lg object-cover"
                                                        src="{{ $dispute->deal->car->images[0] }}"
                                                        alt="{{ $dispute->deal->car->brand }} {{ $dispute->deal->car->model }}">
                                                @else
                                                    <div
                                                        class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-car text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @if ($dispute->deal && $dispute->deal->car)
                                                        {{ $dispute->deal->car->brand }} {{ $dispute->deal->car->model }}
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $dispute->type }}</div>
                                        <div class="text-sm text-gray-500 truncate max-w-xs">
                                            {{ Str::limit($dispute->description, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($dispute->status)
                                            @case('open')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>Открыт
                                                </span>
                                            @break

                                            @case('in_progress')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-cog mr-1"></i>В обработке
                                                </span>
                                            @break

                                            @case('resolved')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check mr-1"></i>Решен
                                                </span>
                                            @break

                                            @case('closed')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-times mr-1"></i>Закрыт
                                                </span>
                                            @break

                                            @default
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $dispute->status }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $dispute->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('disputes.show', $dispute->id) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye mr-1"></i>Просмотр
                                            </a>
                                            @if ($dispute->status === 'open')
                                                <a href="{{ route('disputes.edit', $dispute->id) }}"
                                                    class="text-green-600 hover:text-green-900">
                                                    <i class="fas fa-edit mr-1"></i>Редактировать
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
                @if ($disputes->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $disputes->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-exclamation-triangle text-4xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Нет споров</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        У вас пока нет спорных ситуаций.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
