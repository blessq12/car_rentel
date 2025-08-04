@extends('layouts.app')

@section('title', 'Редактировать объявление - CarRental')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Редактировать объявление</h1>
                <p class="mt-2 text-gray-600">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</p>
            </div>

            <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Основная информация -->
                    <div class="space-y-6">
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700">
                                Марка *
                            </label>
                            <input type="text" id="brand" name="brand" value="{{ old('brand', $car->brand) }}"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Например: Toyota">
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">
                                Модель *
                            </label>
                            <input type="text" id="model" name="model" value="{{ old('model', $car->model) }}"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Например: Camry">
                            @error('model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">
                                Год выпуска *
                            </label>
                            <input type="number" id="year" name="year" value="{{ old('year', $car->year) }}"
                                required min="1990" max="2024"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="2020">
                            @error('year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">
                                Тип топлива *
                            </label>
                            <select id="fuel_type" name="fuel_type" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Выберите тип топлива</option>
                                @foreach (\App\Enums\FuelType::cases() as $fuelType)
                                    <option value="{{ $fuelType->value }}"
                                        {{ old('fuel_type', $car->fuel_type->value) == $fuelType->value ? 'selected' : '' }}>
                                        {{ $fuelType->value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fuel_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price_per_day" class="block text-sm font-medium text-gray-700">
                                Цена за сутки (₽) *
                            </label>
                            <input type="number" id="price_per_day" name="price_per_day"
                                value="{{ old('price_per_day', $car->price_per_day) }}" required min="100"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="2000">
                            @error('price_per_day')
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
                                        {{ old('city_id', $car->city_id) == $city->id ? 'selected' : '' }}>
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
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Описание автомобиля
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Опишите состояние автомобиля, особенности, условия аренды...">{{ old('description', $car->metadata['description'] ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Текущие фотографии -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Текущие фотографии
                            </label>
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                @for ($i = 0; $i < 3; $i++)
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-car text-gray-400"></i>
                                    </div>
                                @endfor
                            </div>

                            <!-- Добавить новые фотографии -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                                <i class="fas fa-camera text-2xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600 mb-2">Добавить новые фотографии</p>
                                <input type="file" name="photos[]" multiple accept="image/*" class="hidden"
                                    id="photos">
                                <label for="photos"
                                    class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 cursor-pointer text-sm">
                                    Выбрать фотографии
                                </label>
                            </div>
                            @error('photos')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Дополнительные характеристики -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Дополнительные характеристики</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="transmission" class="block text-sm font-medium text-gray-700">
                                        Коробка передач
                                    </label>
                                    <select id="transmission" name="transmission"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Выберите</option>
                                        <option value="manual"
                                            {{ old('transmission', $car->metadata['transmission'] ?? '') == 'manual' ? 'selected' : '' }}>
                                            Механика</option>
                                        <option value="automatic"
                                            {{ old('transmission', $car->metadata['transmission'] ?? '') == 'automatic' ? 'selected' : '' }}>
                                            Автомат</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="engine_size" class="block text-sm font-medium text-gray-700">
                                        Объем двигателя (л)
                                    </label>
                                    <input type="number" id="engine_size" name="engine_size"
                                        value="{{ old('engine_size', $car->metadata['engine_size'] ?? '') }}"
                                        step="0.1" min="0.5" max="8.0"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="2.0">
                                </div>

                                <div>
                                    <label for="mileage" class="block text-sm font-medium text-gray-700">
                                        Пробег (км)
                                    </label>
                                    <input type="number" id="mileage" name="mileage"
                                        value="{{ old('mileage', $car->metadata['mileage'] ?? '') }}" min="0"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="50000">
                                </div>

                                <div>
                                    <label for="color" class="block text-sm font-medium text-gray-700">
                                        Цвет
                                    </label>
                                    <input type="text" id="color" name="color"
                                        value="{{ old('color', $car->metadata['color'] ?? '') }}"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Белый">
                                </div>
                            </div>
                        </div>

                        <!-- Платное продвижение -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        Платное продвижение
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Продвигайте свое объявление в топе каталога за 500₽/неделя</p>
                                    </div>
                                    <div class="mt-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_promoted" value="1"
                                                {{ $car->is_promoted ? 'checked' : '' }}
                                                class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-yellow-800">Продвигать объявление</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('cars.show', $car) }}"
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

    @push('scripts')
        <script>
            // Предпросмотр новых фотографий
            document.getElementById('photos').addEventListener('change', function(e) {
                const files = e.target.files;
                const container = document.querySelector('.border-dashed');

                if (files.length > 0) {
                    // Очищаем только содержимое, оставляя структуру
                    const icon = container.querySelector('.fas');
                    const text = container.querySelector('p');
                    const label = container.querySelector('label');

                    container.innerHTML = '';
                    container.appendChild(icon);
                    container.appendChild(text);
                    container.appendChild(label);

                    for (let i = 0; i < Math.min(files.length, 5); i++) {
                        const file = files[i];
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-16 h-16 object-cover rounded-lg inline-block m-1';
                            container.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    }
                }
            });
        </script>
    @endpush
@endsection
