@extends('layouts.app')

@section('title', 'Редактировать спор - CarRental')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Заголовок -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Редактировать спор</h1>
                    <p class="text-gray-600 mt-2">Обновите информацию о спорной ситуации</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('disputes.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Назад к спорам
                    </a>
                </div>
            </div>
        </div>

        <!-- Информация о сделке -->
        @if ($dispute->deal)
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Информация о сделке</h2>
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-16 w-16">
                        @if ($dispute->deal->car && $dispute->deal->car->images && count($dispute->deal->car->images) > 0)
                            <img class="h-16 w-16 rounded-lg object-cover" src="{{ $dispute->deal->car->images[0] }}"
                                alt="{{ $dispute->deal->car->brand }} {{ $dispute->deal->car->model }}">
                        @else
                            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-car text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            @if ($dispute->deal->car)
                                {{ $dispute->deal->car->brand }} {{ $dispute->deal->car->model }}
                            @else
                                Сделка #{{ $dispute->deal_id }}
                            @endif
                        </h3>
                        <p class="text-gray-600">
                            {{ $dispute->deal->start_date->format('d.m.Y') }} -
                            {{ $dispute->deal->end_date->format('d.m.Y') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Статус: {{ ucfirst($dispute->deal->status->value) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Форма редактирования -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('disputes.update', $dispute) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Тип спора -->
                <div class="mb-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Тип спора
                    </label>
                    <input type="text" id="type" name="type" value="{{ old('type', $dispute->type) }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    @error('type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Описание -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Описание проблемы
                    </label>
                    <textarea id="description" name="description" rows="6"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Подробно опишите проблему..." required>{{ old('description', $dispute->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Дополнительные доказательства -->
                <div class="mb-6">
                    <label for="evidence" class="block text-sm font-medium text-gray-700 mb-2">
                        Дополнительные доказательства (фото, документы)
                    </label>
                    <input type="file" id="evidence" name="evidence[]" multiple accept="image/*,.pdf,.doc,.docx"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">
                        Можно загрузить несколько файлов. Поддерживаются изображения, PDF и документы Word.
                    </p>
                    @error('evidence.*')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Существующие доказательства -->
                @if ($dispute->metadata && isset($dispute->metadata['evidence']) && count($dispute->metadata['evidence']) > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Существующие доказательства
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($dispute->metadata['evidence'] as $evidence)
                                <div class="border border-gray-200 rounded-lg p-2">
                                    @if (Str::endsWith($evidence, ['.jpg', '.jpeg', '.png', '.gif']))
                                        <img src="{{ asset('storage/' . $evidence) }}" alt="Доказательство"
                                            class="w-full h-24 object-cover rounded">
                                    @else
                                        <div class="w-full h-24 bg-gray-100 rounded flex items-center justify-center">
                                            <i class="fas fa-file text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1 truncate">
                                        {{ basename($evidence) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Кнопки -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('disputes.show', $dispute) }}"
                        class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition-colors">
                        Отмена
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
