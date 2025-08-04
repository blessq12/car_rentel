@extends('layouts.app')

@section('title', 'Telegram верификация - CarRental')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="flex justify-center">
                    <i class="fab fa-telegram text-6xl text-blue-500"></i>
                </div>
                <h2 class="mt-6 text-3xl font-bold text-gray-900">
                    Подключите Telegram
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Отсканируйте QR-код или нажмите кнопку ниже
                </p>
            </div>

            <div class="bg-white py-8 px-6 shadow rounded-lg">
                <!-- QR-код -->
                <div class="text-center mb-6">
                    <div class="inline-block p-4 bg-white border-2 border-gray-200 rounded-lg">
                        <div class="w-48 h-48 bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-qrcode text-6xl text-gray-400"></i>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">
                        Отсканируйте этот QR-код в Telegram
                    </p>
                </div>

                <!-- Кнопка подключения -->
                <div class="mb-6">
                    <a href="#"
                        class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <i class="fab fa-telegram mr-3 text-xl"></i>
                        Открыть в Telegram
                    </a>
                </div>

                <!-- Инструкции -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">
                        Как подключить:
                    </h3>
                    <ol class="text-sm text-blue-700 space-y-1">
                        <li>1. Откройте Telegram на телефоне</li>
                        <li>2. Отсканируйте QR-код или нажмите кнопку выше</li>
                        <li>3. Нажмите "Start" в чате с ботом</li>
                        <li>4. Подтвердите подключение</li>
                    </ol>
                </div>

                <!-- Статус -->
                <div class="mt-6 text-center">
                    <div
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-2"></i>
                        Ожидание подключения...
                    </div>
                </div>

                <!-- Альтернативные варианты -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            Не получается подключиться?
                        </p>
                        <div class="space-y-2">
                            <a href="#" class="block text-sm text-blue-600 hover:text-blue-500">
                                Попробовать позже
                            </a>
                            <a href="{{ route('auth.login') }}" class="block text-sm text-blue-600 hover:text-blue-500">
                                Войти без Telegram
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Дополнительная информация -->
            <div class="text-center">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-800 mb-2">
                        Зачем нужна верификация?
                    </h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>• Защита от мошенников</p>
                        <p>• Быстрые уведомления о сделках</p>
                        <p>• Удобное общение с арендаторами</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Проверка статуса подключения каждые 5 секунд
            setInterval(function() {
                // TODO: AJAX запрос для проверки статуса
                console.log('Checking Telegram connection status...');
            }, 5000);
        </script>
    @endpush
@endsection
