<footer class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white relative overflow-hidden">
    <!-- Декоративные элементы -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- О платформе -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-6">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-car text-xl text-white"></i>
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">CarRental</span>
                </div>
                <p class="text-gray-300 mb-8 max-w-lg leading-relaxed text-lg">
                    Платформа для аренды автомобилей между частными лицами.
                    Безопасные сделки, проверенные арендаторы и прозрачные условия.
                </p>
                <div class="flex space-x-6">
                    <a href="#"
                        class="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center hover:bg-white/20 transition-all duration-300 transform hover:scale-110 group">
                        <i
                            class="fab fa-telegram text-xl text-blue-400 group-hover:text-blue-300 transition-colors"></i>
                    </a>
                    <a href="#"
                        class="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center hover:bg-white/20 transition-all duration-300 transform hover:scale-110 group">
                        <i class="fab fa-vk text-xl text-blue-400 group-hover:text-blue-300 transition-colors"></i>
                    </a>
                    <a href="#"
                        class="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center hover:bg-white/20 transition-all duration-300 transform hover:scale-110 group">
                        <i
                            class="fab fa-instagram text-xl text-blue-400 group-hover:text-blue-300 transition-colors"></i>
                    </a>
                </div>
            </div>

            <!-- Быстрые ссылки -->
            <div>
                <h3 class="text-xl font-bold mb-6 text-white">Платформа</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('catalog') }}"
                            class="flex items-center text-gray-300 hover:text-white transition-all duration-300 group">
                            <i
                                class="fas fa-car mr-3 text-blue-400 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Каталог авто</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cars.create') }}"
                            class="flex items-center text-gray-300 hover:text-white transition-all duration-300 group">
                            <i
                                class="fas fa-plus mr-3 text-green-400 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Сдать авто</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-300 hover:text-white transition-all duration-300 group">
                            <i
                                class="fas fa-info-circle mr-3 text-cyan-400 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Как это работает</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-300 hover:text-white transition-all duration-300 group">
                            <i
                                class="fas fa-shield-alt mr-3 text-yellow-400 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Безопасность</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Поддержка -->
            <div>
                <h3 class="text-xl font-bold mb-6 text-white">Поддержка</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-300 hover:text-white transition-all duration-300 group">
                            <i
                                class="fas fa-question-circle mr-3 text-blue-400 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Помощь</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-300 hover:text-white transition-all duration-300 group">
                            <i
                                class="fas fa-book mr-3 text-green-400 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Правила</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-300 hover:text-white transition-all duration-300 group">
                            <i
                                class="fas fa-phone mr-3 text-cyan-400 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Контакты</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-300 hover:text-white transition-all duration-300 group">
                            <i
                                class="fas fa-users mr-3 text-yellow-400 group-hover:scale-110 transition-transform duration-300"></i>
                            <span>О нас</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Нижняя часть -->
        <div class="border-t border-white/10 mt-12 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm">
                    © 2024 CarRental. Все права защищены.
                </div>
                <div class="flex space-x-8 mt-4 md:mt-0">
                    <a href="{{ route('privacy') }}"
                        class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:scale-105">
                        Политика конфиденциальности
                    </a>
                    <a href="{{ route('terms') }}"
                        class="text-gray-400 hover:text-white text-sm transition-all duration-300 hover:scale-105">
                        Условия использования
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
