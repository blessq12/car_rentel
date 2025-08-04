@extends('layouts.app')

@section('title', 'Каталог автомобилей - CarRental')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-cyan-50/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Заголовок страницы -->
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-cyan-700 bg-clip-text text-transparent mb-4">
                    Каталог автомобилей
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Найдите идеальный автомобиль для вашей поездки среди тысяч предложений от частных владельцев
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Фильтры -->
                <div class="lg:w-1/4">
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-6 sticky top-24">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Фильтры</h3>
                            <button @click="$dispatch('toggle-filters')" class="lg:hidden text-blue-600 hover:text-blue-700">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>

                        <form action="{{ route('catalog') }}" method="GET" x-data="{
                            showFilters: false,
                            resetFilters() {
                                this.$el.reset();
                                this.$el.submit();
                            }
                        }" class="space-y-6">
                            <!-- Город -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Город</label>
                                <div class="relative">
                                    <select name="city_id"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300">
                                        <option value="">Все города</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-map-marker-alt absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Марка и модель -->
                            <div class="grid grid-cols-1 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Марка</label>
                                    <div class="relative">
                                        <input type="text" name="brand" value="{{ request('brand') }}" placeholder="Любая марка"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300">
                                        <i class="fas fa-car absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Модель</label>
                                    <div class="relative">
                                        <input type="text" name="model" value="{{ request('model') }}" placeholder="Любая модель"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300">
                                        <i class="fas fa-cog absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Год выпуска -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Год выпуска</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="relative">
                                        <input type="number" name="year_min" value="{{ request('year_min') }}" placeholder="От"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300">
                                        <i class="fas fa-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    <div class="relative">
                                        <input type="number" name="year_max" value="{{ request('year_max') }}" placeholder="До"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300">
                                        <i class="fas fa-calendar absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Тип топлива -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Тип топлива</label>
                                <div class="relative">
                                    <select name="fuel_type"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300">
                                        <option value="">Любой</option>
                                        @foreach ($fuelTypes as $fuelType)
                                            <option value="{{ $fuelType->value }}"
                                                {{ request('fuel_type') == $fuelType->value ? 'selected' : '' }}>
                                                {{ $fuelType->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-gas-pump absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Цена -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Цена за сутки</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="relative">
                                        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="От"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300">
                                        <i class="fas fa-ruble-sign absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    <div class="relative">
                                        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="До"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300">
                                        <i class="fas fa-ruble-sign absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="space-y-3 pt-4">
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                                    <i class="fas fa-search mr-2"></i>Применить фильтры
                                </button>
                                <button type="button" @click="resetFilters()"
                                    class="w-full bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
                                    <i class="fas fa-times mr-2"></i>Сбросить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Список автомобилей -->
                <div class="lg:w-3/4">
                    <!-- Заголовок и сортировка -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-6 mb-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Найдено {{ $cars->total() }} автомобилей</h2>
                                <p class="text-gray-600 mt-1">Выберите подходящий вариант для вашей поездки</p>
                            </div>

                            <!-- Сортировка -->
                            <div class="flex items-center space-x-3">
                                <span class="text-sm font-medium text-gray-700">Сортировка:</span>
                                <div class="relative">
                                    <select onchange="window.location.href=this.value"
                                        class="px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white/50 backdrop-blur-sm transition-all duration-300 appearance-none pr-8">
                                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
                                            {{ request('sort') == 'latest' ? 'selected' : '' }}>Сначала новые</option>
                                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}"
                                            {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Дешевле</option>
                                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}"
                                            {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Дороже</option>
                                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}"
                                            {{ request('sort') == 'rating' ? 'selected' : '' }}>По рейтингу</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Список автомобилей -->
                    @if ($cars->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($cars as $car)
                                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                                    <!-- Изображение -->
                                    <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative overflow-hidden">
                                        <i class="fas fa-car text-5xl text-gray-400 group-hover:scale-110 transition-transform duration-300"></i>
                                        @if ($car->is_promoted)
                                            <div class="absolute top-3 right-3 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-lg">
                                                <i class="fas fa-star mr-1"></i>Топ
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                    
                                    <!-- Контент -->
                                    <div class="p-6">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">
                                                {{ $car->brand }} {{ $car->model }}
                                            </h3>
                                        </div>
                                        
                                        <div class="space-y-2 mb-4">
                                            <p class="text-gray-600 flex items-center">
                                                <i class="fas fa-calendar mr-2 text-blue-500"></i>
                                                {{ $car->year }} • {{ $car->fuel_type->value }}
                                            </p>
                                            <p class="text-gray-600 flex items-center">
                                                <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>
                                                {{ $car->city->name }}
                                            </p>
                                        </div>
                                        
                                        <div class="flex justify-between items-center mb-4">
                                            <div>
                                                <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                                                    {{ number_format($car->price_per_day) }} ₽
                                                </span>
                                                <span class="text-sm text-gray-500 block">за сутки</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Владелец и рейтинг -->
                                        <div class="flex items-center justify-between mb-4 p-3 bg-gray-50 rounded-xl">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white text-xs font-bold">{{ substr($car->client->name, 0, 1) }}</span>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700">{{ $car->client->name }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                                <span class="text-sm font-semibold text-gray-700">{{ number_format($car->client->rating, 1) }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Кнопки действий -->
                                        <div class="space-y-3">
                                            <a href="{{ route('cars.show', $car) }}"
                                                class="block w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-center py-3 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                                                <i class="fas fa-eye mr-2"></i>Подробнее
                                            </a>
                                            <button class="w-full border-2 border-blue-500 text-blue-600 py-3 rounded-xl hover:bg-blue-50 transition-all duration-300 font-medium">
                                                <i class="fas fa-comment mr-2"></i>Написать владельцу
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Пагинация -->
                        <div class="mt-8 flex justify-center">
                            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-4">
                                {{ $cars->links() }}
                            </div>
                        </div>
                    @else
                        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 p-12 text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-car text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-700 mb-4">Автомобили не найдены</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                                Попробуйте изменить параметры поиска или расширить критерии фильтрации
                            </p>
                            <a href="{{ route('catalog') }}"
                                class="inline-flex items-center bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-8 py-3 rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                                <i class="fas fa-refresh mr-2"></i>Сбросить фильтры
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
