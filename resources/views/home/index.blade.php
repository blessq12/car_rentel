@extends('layouts.app')

@section('title', 'CarRental - Аренда автомобилей')

@section('content')
    <!-- Главный баннер -->
    <div class="relative min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
        <!-- Анимированный фон -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20"></div>
            <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute top-0 right-0 w-72 h-72 bg-purple-500/30 rounded-full blur-3xl animate-pulse delay-1000">
            </div>
            <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-cyan-500/30 rounded-full blur-3xl animate-pulse delay-2000">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-[80vh]">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <div
                            class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-sm">
                            <i class="fas fa-star mr-2 text-yellow-400"></i>
                            Более 10,000+ довольных клиентов
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-bold text-white leading-tight">
                            Аренда авто
                            <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                                без хлопот
                            </span>
                        </h1>
                        <p class="text-xl lg:text-2xl text-white/80 leading-relaxed">
                            Найди идеальный автомобиль за минуты. Без скрытых комиссий, без лишних документов.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('catalog') }}"
                            class="group relative px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl font-semibold text-white hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <span class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-search mr-3"></i>
                                Найти авто
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </a>
                        <a href="{{ route('cars.create') }}"
                            class="group px-8 py-4 border-2 border-white/30 text-white rounded-xl font-semibold hover:bg-white/10 backdrop-blur-sm transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-plus mr-3"></i>
                            Сдать авто
                        </a>
                    </div>

                    <!-- Статистика -->
                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ \App\Models\Car::count() }}+</div>
                            <div class="text-white/70 text-sm">Автомобилей</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ \App\Models\City::count() }}+</div>
                            <div class="text-white/70 text-sm">Городов</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ \App\Models\Client::count() }}+</div>
                            <div class="text-white/70 text-sm">Клиентов</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-2xl">
                        <h3 class="text-2xl font-bold text-white mb-6">Быстрый поиск</h3>
                        <form class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <select
                                        class="w-full px-4 py-4 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                                        <option class="text-gray-800">Выберите город</option>
                                        <option class="text-gray-800">Москва</option>
                                        <option class="text-gray-800">Санкт-Петербург</option>
                                        <option class="text-gray-800">Казань</option>
                                    </select>
                                    <i
                                        class="fas fa-map-marker-alt absolute right-4 top-1/2 transform -translate-y-1/2 text-white/50"></i>
                                </div>
                                <div class="relative">
                                    <select
                                        class="w-full px-4 py-4 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                                        <option class="text-gray-800">Марка</option>
                                        <option class="text-gray-800">Toyota</option>
                                        <option class="text-gray-800">BMW</option>
                                        <option class="text-gray-800">Mercedes</option>
                                    </select>
                                    <i
                                        class="fas fa-car absolute right-4 top-1/2 transform -translate-y-1/2 text-white/50"></i>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="date" placeholder="Дата начала"
                                        class="w-full px-4 py-4 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                                    <i
                                        class="fas fa-calendar absolute right-4 top-1/2 transform -translate-y-1/2 text-white/50"></i>
                                </div>
                                <div class="relative">
                                    <input type="date" placeholder="Дата окончания"
                                        class="w-full px-4 py-4 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                                    <i
                                        class="fas fa-calendar absolute right-4 top-1/2 transform -translate-y-1/2 text-white/50"></i>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white py-4 rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-search mr-2"></i>
                                Найти автомобиль
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Статистика -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ \App\Models\Car::count() }}+</div>
                    <div class="text-gray-600">Автомобилей</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ \App\Models\City::count() }}+</div>
                    <div class="text-gray-600">Городов</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">
                        {{ \App\Models\Deal::where('status', \App\Enums\DealStatus::COMPLETED)->count() }}+</div>
                    <div class="text-gray-600">Успешных сделок</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ \App\Models\Client::count() }}+</div>
                    <div class="text-gray-600">Довольных клиентов</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Преимущества -->
    <div class="py-24 bg-gradient-to-br from-slate-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Почему выбирают нас</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Мы создали платформу, которая делает аренду автомобилей
                    простой, безопасной и выгодной для всех участников</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div
                    class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-shield-alt text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Безопасность</h3>
                        <p class="text-gray-600 leading-relaxed">Все автомобили застрахованы, водители проверены через нашу
                            систему верификации</p>
                    </div>
                </div>

                <div
                    class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-bolt text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Мгновенно</h3>
                        <p class="text-gray-600 leading-relaxed">Бронирование за 5 минут, получение авто в течение часа.
                            Никаких очередей</p>
                    </div>
                </div>

                <div
                    class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-orange-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-coins text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Выгодно</h3>
                        <p class="text-gray-600 leading-relaxed">Цены на 30% ниже, чем у прокатных компаний. Никаких
                            скрытых комиссий</p>
                    </div>
                </div>

                <div
                    class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-headset text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Поддержка 24/7</h3>
                        <p class="text-gray-600 leading-relaxed">Круглосуточная поддержка и помощь на дороге. Мы всегда на
                            связи</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Популярные автомобили -->
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Популярные автомобили</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Самые востребованные автомобили наших пользователей</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach (\App\Models\Car::where('is_promoted', true)->take(8)->get() as $car)
                    <div
                        class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                        <div
                            class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <i
                                class="fas fa-car text-6xl text-gray-400 group-hover:scale-110 transition-transform duration-300"></i>
                            @if ($car->is_promoted)
                                <div
                                    class="absolute top-4 right-4 bg-gradient-to-r from-yellow-400 to-orange-400 text-white text-xs px-3 py-1 rounded-full font-bold shadow-lg">
                                    <i class="fas fa-star mr-1"></i>ТОП
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-gray-900">{{ $car->brand }} {{ $car->model }}</h3>
                                <div class="flex items-center text-yellow-400">
                                    <i class="fas fa-star text-sm"></i>
                                    <span class="text-sm text-gray-600 ml-1">4.8</span>
                                </div>
                            </div>
                            <div class="flex items-center text-gray-600 text-sm mb-4">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>{{ $car->year }} • {{ $car->fuel_type->value }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 text-sm mb-4">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $car->city->name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-2xl font-bold text-blue-600">{{ number_format($car->price_per_day) }}</span>
                                    <span class="text-gray-600">₽/день</span>
                                </div>
                                <a href="{{ route('cars.show', $car) }}"
                                    class="group/btn bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-4 py-2 rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <span class="flex items-center">
                                        Подробнее
                                        <i
                                            class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('catalog') }}"
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-search mr-3"></i>
                    Смотреть все автомобили
                </a>
            </div>
        </div>
    </div>

    <!-- Отзывы клиентов -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Отзывы наших клиентов</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach (\App\Models\Review::with('reviewer')->take(3)->get() as $review)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-semibold">{{ substr($review->reviewer->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h4 class="font-semibold">{{ $review->reviewer->name }}</h4>
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-4">{{ $review->comment }}</p>
                        <p class="text-sm text-gray-500">{{ $review->created_at->format('d.m.Y') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Как это работает -->
    <div class="bg-blue-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Как это работает</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold">
                        1
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Выберите автомобиль</h3>
                    <p class="text-gray-600">Найдите подходящий автомобиль в нашем каталоге по марке, цене или
                        местоположению</p>
                </div>
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold">
                        2
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Свяжитесь с владельцем</h3>
                    <p class="text-gray-600">Напишите владельцу через встроенный чат и обсудите детали аренды</p>
                </div>
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold">
                        3
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Получите автомобиль</h3>
                    <p class="text-gray-600">Встретьтесь с владельцем, подпишите договор и отправляйтесь в путь</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Реферальная программа -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-8 text-white text-center">
                <h2 class="text-3xl font-bold mb-4">Приглашай друзей и получай бонусы!</h2>
                <p class="text-xl mb-6 text-green-100">За каждого приглашенного друга получай бесплатное объявление на 7
                    дней</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button
                        class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-share mr-2"></i>Поделиться
                    </button>
                    <button
                        class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors">
                        <i class="fas fa-gift mr-2"></i>Мои бонусы
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Города -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Популярные города</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach (\App\Models\City::where('is_active', true)->take(12)->get() as $city)
                    <div class="bg-white rounded-lg p-4 text-center hover:shadow-md transition-shadow cursor-pointer">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-map-marker-alt text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">{{ $city->name }}</h3>
                        <p class="text-sm text-gray-500">{{ \App\Models\Car::where('city_id', $city->id)->count() }} авто
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- PWA Установка -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-6">Установите приложение на экран домой</h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Добавьте CarRental на главный экран вашего устройства и получайте мгновенные уведомления о новых
                        предложениях, сообщениях и статусе заявок.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-bell text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Push-уведомления</h3>
                                <p class="text-gray-600 text-sm">Получайте уведомления о новых сообщениях и заявках</p>
                            </div>
                        </div>
                        <div class="flex items-center p-4 bg-green-50 rounded-lg">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-bolt text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Быстрый доступ</h3>
                                <p class="text-gray-600 text-sm">Открывайте приложение одним касанием</p>
                            </div>
                        </div>
                        <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-wifi text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Работает офлайн</h3>
                                <p class="text-gray-600 text-sm">Просматривайте каталог даже без интернета</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button id="installPWA"
                            class="bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center">
                            <i class="fas fa-download mr-3"></i>
                            Установить приложение
                        </button>
                        <p class="text-sm text-gray-500 mt-2">Доступно для iOS и Android</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="relative">
                        <div
                            class="w-64 h-96 bg-gradient-to-b from-blue-500 to-blue-600 rounded-3xl mx-auto flex items-center justify-center shadow-2xl">
                            <div class="text-center text-white">
                                <i class="fas fa-home text-4xl mb-4"></i>
                                <p class="text-lg font-semibold">Добавить на главный экран</p>
                            </div>
                        </div>
                        <div
                            class="absolute -top-4 -right-4 w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg">
                            <i class="fas fa-plus text-yellow-800 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Часто задаваемые вопросы</h2>
            <div class="space-y-6">
                <div class="bg-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-3">Как зарегистрироваться на платформе?</h3>
                    <p class="text-gray-600">Зарегистрироваться можно через email или через Telegram. Для полного доступа к
                        функциям необходимо пройти верификацию.</p>
                </div>
                <div class="bg-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-3">Какие документы нужны для аренды?</h3>
                    <p class="text-gray-600">Для аренды автомобиля нужны водительские права и паспорт. Некоторые владельцы
                        могут запросить дополнительные документы.</p>
                </div>
                <div class="bg-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-3">Что делать в случае аварии?</h3>
                    <p class="text-gray-600">При аварии немедленно свяжитесь с владельцем автомобиля и службой поддержки.
                        Все автомобили застрахованы.</p>
                </div>
                <div class="bg-white rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-3">Как работает система отзывов?</h3>
                    <p class="text-gray-600">После завершения аренды обе стороны могут оставить отзыв друг о друге. Это
                        помогает поддерживать качество сервиса.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // PWA Install functionality
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent Chrome 67 and earlier from automatically showing the prompt
            e.preventDefault();
            // Stash the event so it can be triggered later
            deferredPrompt = e;

            // Show the install button
            const installButton = document.getElementById('installPWA');
            if (installButton) {
                installButton.style.display = 'flex';
                installButton.addEventListener('click', () => {
                    // Show the install prompt
                    deferredPrompt.prompt();
                    // Wait for the user to respond to the prompt
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the install prompt');
                        } else {
                            console.log('User dismissed the install prompt');
                        }
                        deferredPrompt = null;
                        installButton.style.display = 'none';
                    });
                });
            }
        });

        // Hide install button if PWA is already installed
        window.addEventListener('appinstalled', (evt) => {
            const installButton = document.getElementById('installPWA');
            if (installButton) {
                installButton.style.display = 'none';
            }
            console.log('PWA was installed');
        });

        // Check if app is already installed
        if (window.matchMedia('(display-mode: standalone)').matches) {
            const installButton = document.getElementById('installPWA');
            if (installButton) {
                installButton.style.display = 'none';
            }
        }
    </script>
@endpush
