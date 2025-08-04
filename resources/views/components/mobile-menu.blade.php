<div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-full"
    x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-full" class="md:hidden fixed inset-0 z-50">

    <!-- Затемнение -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

    <!-- Меню -->
    <div class="fixed top-0 right-0 w-80 h-full bg-white/95 backdrop-blur-xl shadow-2xl border-l border-white/20">
        <!-- Заголовок -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-blue-500 to-cyan-500">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-car text-white"></i>
                </div>
                <h3 class="text-lg font-bold text-white">CarRental</h3>
            </div>
            <button @click="open = false"
                class="text-white/80 hover:text-white transition-colors duration-300 p-2 rounded-xl hover:bg-white/20">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Поиск -->
        <div class="p-6 border-b border-gray-100">
            <form action="{{ route('search') }}" method="GET" class="flex">
                <div class="relative flex-1">
                    <input type="text" name="q" placeholder="Поиск авто..."
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/50 backdrop-blur-sm">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="submit"
                    class="ml-3 px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                    <i class="fas fa-search mr-2"></i>Найти
                </button>
            </form>
        </div>

        <!-- Навигация -->
        <nav class="p-6">
            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Навигация</h4>
            <div class="space-y-2">
                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 rounded-xl transition-all duration-300 group">
                    <i
                        class="fas fa-home mr-3 text-blue-500 group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="font-medium">Главная</span>
                </a>
                <a href="{{ route('catalog') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 rounded-xl transition-all duration-300 group">
                    <i
                        class="fas fa-search mr-3 text-green-500 group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="font-medium">Каталог</span>
                </a>
                <a href="{{ route('cars.create') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 rounded-xl transition-all duration-300 group">
                    <i
                        class="fas fa-plus mr-3 text-orange-500 group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="font-medium">Сдать авто</span>
                </a>
            </div>
        </nav>

        <!-- Пользователь -->
        @php
            $currentClient = \App\Http\Controllers\AuthController::getCurrentClient();
        @endphp

        @if ($currentClient)
            <div class="p-6 border-t border-gray-100">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Аккаунт</h4>

                <!-- Информация о пользователе -->
                <div class="flex items-center mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">{{ substr($currentClient->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900">{{ $currentClient->name }}</div>
                        <div class="text-sm text-gray-500">{{ $currentClient->email }}</div>
                        @if ($currentClient->is_verified)
                            <div class="flex items-center mt-1">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                <span class="text-xs text-green-600 font-medium">Верифицирован</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Меню пользователя -->
                <div class="space-y-2">
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 rounded-xl transition-all duration-300 group">
                        <i
                            class="fas fa-user mr-3 text-blue-500 group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="font-medium">Профиль</span>
                    </a>
                    <a href="{{ route('chat.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 rounded-xl transition-all duration-300 group">
                        <i
                            class="fas fa-comments mr-3 text-green-500 group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="font-medium">Чаты</span>
                        <span
                            class="ml-auto bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-2 py-1 font-bold">3</span>
                    </a>
                    <a href="{{ route('disputes.index') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 rounded-xl transition-all duration-300 group">
                        <i
                            class="fas fa-exclamation-triangle mr-3 text-orange-500 group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="font-medium">Споры</span>
                    </a>
                </div>

                <!-- Выход -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 rounded-xl transition-all duration-300 group">
                            <i
                                class="fas fa-sign-out-alt mr-3 text-red-500 group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="font-medium">Выйти</span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="p-6 border-t border-gray-100">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Авторизация</h4>
                <div class="space-y-3">
                    <a href="{{ route('auth.login') }}"
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 rounded-xl transition-all duration-300 group">
                        <i
                            class="fas fa-sign-in-alt mr-3 text-blue-500 group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="font-medium">Войти</span>
                    </a>
                    <a href="{{ route('auth.register') }}"
                        class="flex items-center px-4 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 transform hover:scale-105 shadow-lg font-semibold">
                        <i class="fas fa-user-plus mr-3"></i>
                        Регистрация
                    </a>
                </div>
            </div>
        @endif

        <!-- Дополнительная информация -->
        <div class="p-6 border-t border-gray-100 mt-auto">
            <div class="text-center">
                <p class="text-xs text-gray-500 mb-2">© 2024 CarRental</p>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors duration-300">
                        <i class="fab fa-telegram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors duration-300">
                        <i class="fab fa-vk text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors duration-300">
                        <i class="fas fa-envelope text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
