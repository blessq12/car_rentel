@extends('layouts.app')

@section('title', 'Редактировать спор - CarRental')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-orange-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Заголовок -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1
                            class="text-3xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">
                            Редактировать спор
                        </h1>
                        <p class="text-gray-600 mt-2 text-lg">Обновите информацию о спорной ситуации</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('disputes.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Назад к спорам
                        </a>
                    </div>
                </div>
            </div>

            <!-- Информация о сделке -->
            @if ($dispute->deal)
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Информация о сделке</h2>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <div class="flex-shrink-0 h-20 w-20">
                            @if ($dispute->deal->car && $dispute->deal->car->images && count($dispute->deal->car->images) > 0)
                                <img class="h-20 w-20 rounded-2xl object-cover shadow-lg"
                                    src="{{ $dispute->deal->car->images[0] }}"
                                    alt="{{ $dispute->deal->car->brand }} {{ $dispute->deal->car->model }}">
                            @else
                                <div
                                    class="h-20 w-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-car text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                @if ($dispute->deal->car)
                                    {{ $dispute->deal->car->brand }} {{ $dispute->deal->car->model }}
                                @else
                                    Сделка #{{ $dispute->deal_id }}
                                @endif
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-700">Период аренды:</span>
                                    <p class="text-gray-600">
                                        {{ $dispute->deal->start_date->format('d.m.Y') }} -
                                        {{ $dispute->deal->end_date->format('d.m.Y') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Статус:</span>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        {{ ucfirst($dispute->deal->status->value) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Форма редактирования -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                <form action="{{ route('disputes.update', $dispute) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Тип спора -->
                    <div class="mb-6">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-3">
                            Тип спора
                        </label>
                        <input type="text" id="type" name="type" value="{{ old('type', $dispute->type) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                            placeholder="Например: Повреждение автомобиля, нарушение условий аренды..." required>
                        @error('type')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Описание -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-3">
                            Описание проблемы
                        </label>
                        <textarea id="description" name="description" rows="6"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none transition-all duration-200"
                            placeholder="Подробно опишите проблему, укажите детали и обстоятельства..." required>{{ old('description', $dispute->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Дополнительные доказательства -->
                    <div class="mb-6">
                        <label for="evidence" class="block text-sm font-medium text-gray-700 mb-3">
                            Дополнительные доказательства
                        </label>
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-red-400 transition-colors duration-200">
                            <input type="file" id="evidence" name="evidence[]" multiple accept="image/*,.pdf,.doc,.docx"
                                class="hidden">
                            <label for="evidence" class="cursor-pointer">
                                <div
                                    class="mx-auto w-12 h-12 bg-gradient-to-br from-red-100 to-orange-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-red-600"></i>
                                </div>
                                <p class="text-lg font-medium text-gray-900 mb-2">Загрузить файлы</p>
                                <p class="text-sm text-gray-500 mb-4">
                                    Перетащите файлы сюда или нажмите для выбора
                                </p>
                                <p class="text-xs text-gray-400">
                                    Поддерживаются: изображения, PDF, документы Word
                                </p>
                            </label>
                        </div>
                        @error('evidence.*')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Существующие доказательства -->
                    @if ($dispute->metadata && isset($dispute->metadata['evidence']) && count($dispute->metadata['evidence']) > 0)
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Существующие доказательства
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($dispute->metadata['evidence'] as $evidence)
                                    <div
                                        class="border border-gray-200 rounded-xl p-3 hover:shadow-lg transition-shadow duration-200">
                                        @if (Str::endsWith($evidence, ['.jpg', '.jpeg', '.png', '.gif']))
                                            <img src="{{ asset('storage/' . $evidence) }}" alt="Доказательство"
                                                class="w-full h-24 object-cover rounded-lg">
                                        @else
                                            <div
                                                class="w-full h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-file text-gray-400 text-2xl"></i>
                                            </div>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-2 truncate">
                                            {{ basename($evidence) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Кнопки -->
                    <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-200/50">
                        <a href="{{ route('disputes.show', $dispute) }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            Отмена
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-xl hover:from-red-700 hover:to-orange-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Drag and drop для файлов
        const dropZone = document.querySelector('.border-dashed');
        const fileInput = document.getElementById('evidence');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-red-400', 'bg-red-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-red-400', 'bg-red-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
        }
    </script>
@endsection
