<nav class="bg-white/90 backdrop-blur-xl shadow-xl border-b border-white/20 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Логотип и основное меню -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <i class="fas fa-car text-xl text-white"></i>
                        </div>
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-cyan-700 bg-clip-text text-transparent">CarRental</span>
                    </a>
                </div>

                <!-- Десктопное меню -->
                <div class="hidden md:ml-8 md:flex md:space-x-2">
                    <a href="{{ route('home') }}"
                        class="relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 hover:text-blue-600 transition-all duration-300 group">
                        <span class="relative z-10">Главная</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                    <a href="{{ route('catalog') }}"
                        class="relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 hover:text-blue-600 transition-all duration-300 group">
                        <span class="relative z-10">Каталог</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                    <a href="{{ route('cars.create') }}"
                        class="relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 hover:text-blue-600 transition-all duration-300 group">
                        <span class="relative z-10">Сдать авто</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Правая часть навигации -->
            <div class="flex items-center space-x-4">
                <!-- Поиск -->
                <div class="hidden md:block">
                    <form action="{{ route('search') }}" method="GET" class="flex">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Поиск авто..."
                                class="w-72 pl-12 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/50 backdrop-blur-sm focus:bg-white transition-all duration-300">
                            <i
                                class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button type="submit"
                            class="ml-3 px-6 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl hover:from-blue-600 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                            <i class="fas fa-search mr-2"></i>Найти
                        </button>
                    </form>
                </div>

                <!-- Кнопки авторизации -->
                <div class="flex items-center space-x-3">
                    @php
                        $currentClient = \App\Http\Controllers\AuthController::getCurrentClient();
                    @endphp

                    @if ($currentClient)
                        <!-- Уведомления -->
                        <button
                            class="relative p-3 text-gray-600 hover:text-blue-600 transition-colors duration-300 group bg-white/50 backdrop-blur-sm rounded-xl hover:bg-white/80">
                            <i class="fas fa-bell text-lg group-hover:scale-110 transition-transform duration-300"></i>
                            <span
                                class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center shadow-lg animate-pulse font-bold">
                                3
                            </span>
                        </button>

                        <!-- Профиль -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-3 text-gray-700 hover:text-blue-600 transition-colors duration-300 group bg-white/50 backdrop-blur-sm rounded-xl px-4 py-2 hover:bg-white/80">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span
                                        class="text-white text-sm font-bold">{{ substr($currentClient->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden md:block text-sm font-semibold">{{ $currentClient->name }}</span>
                                <i
                                    class="fas fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl py-3 z-50 border border-white/20">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ $currentClient->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $currentClient->email }}</p>
                                </div>

                                <div class="py-2">
                                    <a href="{{ route('profile.index') }}"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 transition-colors duration-300 group">
                                        <i
                                            class="fas fa-user mr-3 text-blue-500 group-hover:scale-110 transition-transform duration-300"></i>
                                        <span>Профиль</span>
                                    </a>
                                    <a href="{{ route('chat.index') }}"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-colors duration-300 group">
                                        <i
                                            class="fas fa-comments mr-3 text-green-500 group-hover:scale-110 transition-transform duration-300"></i>
                                        <span>Чаты</span>
                                    </a>
                                    <a href="{{ route('disputes.index') }}"
                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 transition-colors duration-300 group">
                                        <i
                                            class="fas fa-exclamation-triangle mr-3 text-orange-500 group-hover:scale-110 transition-transform duration-300"></i>
                                        <span>Споры</span>
                                    </a>
                                </div>

                                <div class="border-t border-gray-100 pt-2">
                                    <form method="POST" action="{{ route('auth.logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-colors duration-300 group">
                                            <i
                                                class="fas fa-sign-out-alt mr-3 text-red-500 group-hover:scale-110 transition-transform duration-300"></i>
                                            <span>Выйти</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('auth.login') }}"
                            class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-white/50 backdrop-blur-sm">
                            Войти
                        </a>
                        <a href="{{ route('auth.register') }}"
                            class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Регистрация
                        </a>
                    @endif
                </div>

                <!-- Мобильная кнопка меню -->
                <div class="md:hidden">
                    <button @click="$dispatch('toggle-mobile-menu')"
                        class="text-gray-600 hover:text-blue-600 transition-colors duration-300 p-3 rounded-xl hover:bg-white/50 backdrop-blur-sm">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>
