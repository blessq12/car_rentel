@extends('layouts.app')

@section('title', 'Сдать автомобиль - CarRental')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-cyan-50/30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Заголовок страницы -->
            <div class="text-center mb-8">
                <h1
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-cyan-700 bg-clip-text text-transparent mb-4">
                    Сдать автомобиль в аренду
                </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Разместите объявление о сдаче вашего автомобиля и начните зарабатывать на аренде
                </p>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <!-- Заголовок формы -->
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-8 py-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-car text-2xl text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Информация об автомобиле</h2>
                            <p class="text-blue-100 mt-1">Заполните основные данные о вашем автомобиле</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Основная информация -->
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                                Основная информация
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="brand" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Марка автомобиля *
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300"
                                            placeholder="Например: Toyota">
                                        <i
                                            class="fas fa-car absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('brand')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="model" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Модель автомобиля *
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="model" name="model" value="{{ old('model') }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300"
                                            placeholder="Например: Camry">
                                        <i
                                            class="fas fa-cog absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('model')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Год выпуска *
                                        </label>
                                        <div class="relative">
                                            <input type="number" id="year" name="year" value="{{ old('year') }}"
                                                required min="1990" max="2024"
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300"
                                                placeholder="2020">
                                            <i
                                                class="fas fa-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                        @error('year')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="fuel_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Тип топлива *
                                        </label>
                                        <div class="relative">
                                            <select id="fuel_type" name="fuel_type" required
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300 appearance-none">
                                                <option value="">Выберите тип</option>
                                                @foreach (\App\Enums\FuelType::cases() as $fuelType)
                                                    <option value="{{ $fuelType->value }}"
                                                        {{ old('fuel_type') == $fuelType->value ? 'selected' : '' }}>
                                                        {{ $fuelType->value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <i
                                                class="fas fa-gas-pump absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                        @error('fuel_type')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="price_per_day" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Цена за сутки (₽) *
                                        </label>
                                        <div class="relative">
                                            <input type="number" id="price_per_day" name="price_per_day"
                                                value="{{ old('price_per_day') }}" required min="100"
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300"
                                                placeholder="2000">
                                            <i
                                                class="fas fa-ruble-sign absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                        @error('price_per_day')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="city_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Город *
                                        </label>
                                        <div class="relative">
                                            <select id="city_id" name="city_id" required
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300 appearance-none">
                                                <option value="">Выберите город</option>
                                                @foreach (\App\Models\City::where('is_active', true)->get() as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <i
                                                class="fas fa-map-marker-alt absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        </div>
                                        @error('city_id')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Дополнительная информация -->
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-plus-circle text-green-500 mr-3"></i>
                                Дополнительная информация
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Описание автомобиля
                                    </label>
                                    <textarea id="description" name="description" rows="4"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300 resize-none"
                                        placeholder="Опишите состояние автомобиля, особенности, условия аренды...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Фотографии -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Фотографии автомобиля
                                    </label>
                                    <div
                                        class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-blue-400 transition-colors duration-300 bg-white/30 backdrop-blur-sm">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-camera text-2xl text-blue-500"></i>
                                        </div>
                                        <p class="text-gray-600 mb-4 font-medium">Перетащите фотографии сюда или нажмите
                                            для выбора</p>
                                        <input type="file" name="photos[]" multiple accept="image/*" class="hidden"
                                            id="photos">
                                        <label for="photos"
                                            class="inline-flex items-center bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold cursor-pointer">
                                            <i class="fas fa-upload mr-2"></i>Выбрать фотографии
                                        </label>
                                        <p class="text-sm text-gray-500 mt-3">Максимум 5 фотографий, до 5MB каждая</p>
                                    </div>
                                    @error('photos')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Дополнительные характеристики -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-cogs text-orange-500 mr-2"></i>
                                        Технические характеристики
                                    </h4>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="transmission"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Коробка передач
                                            </label>
                                            <div class="relative">
                                                <select id="transmission" name="transmission"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300 appearance-none">
                                                    <option value="">Выберите</option>
                                                    <option value="manual"
                                                        {{ old('transmission') == 'manual' ? 'selected' : '' }}>
                                                        Механика</option>
                                                    <option value="automatic"
                                                        {{ old('transmission') == 'automatic' ? 'selected' : '' }}>
                                                        Автомат</option>
                                                </select>
                                                <i
                                                    class="fas fa-cog absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="engine_size" class="block text-sm font-medium text-gray-700 mb-2">
                                                Объем двигателя (л)
                                            </label>
                                            <div class="relative">
                                                <input type="number" id="engine_size" name="engine_size"
                                                    value="{{ old('engine_size') }}" step="0.1" min="0.5"
                                                    max="8.0"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300"
                                                    placeholder="2.0">
                                                <i
                                                    class="fas fa-tachometer-alt absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="mileage" class="block text-sm font-medium text-gray-700 mb-2">
                                                Пробег (км)
                                            </label>
                                            <div class="relative">
                                                <input type="number" id="mileage" name="mileage"
                                                    value="{{ old('mileage') }}" min="0"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300"
                                                    placeholder="50000">
                                                <i
                                                    class="fas fa-road absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                                                Цвет
                                            </label>
                                            <div class="relative">
                                                <input type="text" id="color" name="color"
                                                    value="{{ old('color') }}"
                                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300"
                                                    placeholder="Белый">
                                                <i
                                                    class="fas fa-palette absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Платное продвижение -->
                                <div
                                    class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-2xl p-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-star text-white"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h4 class="text-lg font-semibold text-yellow-800 mb-2">
                                                Платное продвижение
                                            </h4>
                                            <p class="text-yellow-700 mb-4">
                                                Продвигайте свое объявление в топе каталога и получайте больше заявок
                                            </p>
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <span class="text-2xl font-bold text-yellow-800">500₽</span>
                                                    <span class="text-sm text-yellow-600 ml-1">/неделя</span>
                                                </div>
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="checkbox" name="is_promoted" value="1"
                                                        class="h-5 w-5 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded transition-all duration-300">
                                                    <span class="ml-3 text-sm font-medium text-yellow-800">Продвигать
                                                        объявление</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('catalog') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-300 font-semibold">
                            <i class="fas fa-times mr-2"></i>Отмена
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                            <i class="fas fa-plus mr-2"></i>Опубликовать объявление
                        </button>
                    </div>
                </form>
            </div>

            <!-- Информация о правилах -->
            <div class="mt-8 bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-2xl p-8">
                <div class="flex items-start">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-white text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-blue-900 mb-4">Правила размещения объявлений</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                            <div class="space-y-2">
                                <p class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Максимум 5 бесплатных объявлений на пользователя
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Фотографии должны быть качественными и актуальными
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Запрещено размещать объявления с недостоверной информацией
                                </p>
                            </div>
                            <div class="space-y-2">
                                <p class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Администрация оставляет за собой право модерировать объявления
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    При нарушении правил объявление может быть удалено
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Рекомендуется указывать актуальную информацию о состоянии авто
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Предпросмотр фотографий
            document.getElementById('photos').addEventListener('change', function(e) {
                const files = e.target.files;
                const container = document.querySelector('.border-dashed');

                if (files.length > 0) {
                    // Очищаем контейнер
                    const iconContainer = container.querySelector('.w-16.h-16');
                    const text = container.querySelector('p');
                    const button = container.querySelector('label');
                    const info = container.querySelector('p:last-child');

                    container.innerHTML = '';
                    container.appendChild(iconContainer);
                    container.appendChild(text);
                    container.appendChild(button);
                    container.appendChild(info);

                    // Добавляем превью изображений
                    const previewContainer = document.createElement('div');
                    previewContainer.className = 'grid grid-cols-3 gap-3 mt-4';
                    container.appendChild(previewContainer);

                    for (let i = 0; i < Math.min(files.length, 5); i++) {
                        const file = files[i];
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-full h-24 object-cover rounded-xl shadow-md';
                            previewContainer.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    }
                }
            });
        </script>
    @endpush
@endsection
