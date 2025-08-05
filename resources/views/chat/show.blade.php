@extends('layouts.app')

@section('title', 'Чат - CarRental')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Заголовок чата -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                            <i class="fas fa-arrow-left text-2xl"></i>
                        </a>

                        <div>
                            <h1
                                class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                @if ($chat->deal && $chat->deal->car)
                                    {{ $chat->deal->car->brand }} {{ $chat->deal->car->model }}
                                @else
                                    Чат #{{ $chat->id }}
                                @endif
                            </h1>
                            <p class="text-gray-600 mt-1">
                                @if ($chat->deal)
                                    @if (auth()->check() && auth()->user()->client && auth()->user()->client->id === $chat->deal->client_id)
                                        Арендатор: {{ $chat->deal->renter->name ?? 'Неизвестно' }}
                                    @else
                                        Арендодатель: {{ $chat->deal->client->name ?? 'Неизвестно' }}
                                    @endif
                                @else
                                    Участники чата
                                @endif
                            </p>
                        </div>
                    </div>

                    @if ($chat->deal)
                        <a href="{{ route('deals.show', $chat->deal->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-eye mr-2"></i>Просмотр сделки
                        </a>
                    @endif
                </div>
            </div>

            <!-- Сообщения -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl h-96 flex flex-col border border-white/20">
                <!-- Область сообщений -->
                <div class="flex-1 overflow-y-auto p-6" id="messages-container">
                    @if ($messages->count() > 0)
                        @foreach ($messages as $message)
                            <div
                                class="mb-4 {{ $message->sender_id === (auth()->user()->client->id ?? 0) ? 'text-right' : 'text-left' }}">
                                <div
                                    class="inline-block max-w-xs lg:max-w-md px-4 py-3 rounded-2xl shadow-lg {{ $message->sender_id === (auth()->user()->client->id ?? 0) ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white' : 'bg-white text-gray-900 border border-gray-200' }}">
                                    <div class="text-sm leading-relaxed">
                                        {{ $message->content }}
                                    </div>
                                    <div
                                        class="text-xs mt-2 flex items-center justify-between {{ $message->sender_id === (auth()->user()->client->id ?? 0) ? 'text-blue-100' : 'text-gray-500' }}">
                                        <span>{{ $message->created_at->format('H:i') }}</span>
                                        @if ($message->sender_id === (auth()->user()->client->id ?? 0))
                                            @if ($message->is_read)
                                                <i class="fas fa-check-double ml-2 text-blue-200"></i>
                                            @else
                                                <i class="fas fa-check ml-2 text-blue-200"></i>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <div
                                class="mx-auto w-16 h-16 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-comments text-2xl text-blue-600"></i>
                            </div>
                            <p class="text-lg font-medium">Начните общение</p>
                            <p class="text-sm mt-1">Отправьте первое сообщение</p>
                        </div>
                    @endif
                </div>

                <!-- Форма отправки сообщения -->
                <div class="border-t border-gray-200/50 p-6">
                    <form id="message-form" class="flex space-x-4">
                        @csrf
                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">

                        <div class="flex-1">
                            <textarea name="content" rows="2"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                placeholder="Введите сообщение..." required></textarea>
                        </div>

                        <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-paper-plane text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Автопрокрутка к последнему сообщению
        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }

        // Прокрутка при загрузке страницы
        document.addEventListener('DOMContentLoaded', scrollToBottom);

        // Отправка сообщения через AJAX
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const textarea = form.querySelector('textarea');

            // Блокируем кнопку
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin text-lg"></i>';

            fetch('{{ route('chat.send') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Очищаем поле ввода
                        textarea.value = '';

                        // Добавляем новое сообщение в чат
                        const messagesContainer = document.getElementById('messages-container');
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'mb-4 text-right';
                        messageDiv.innerHTML = `
                        <div class="inline-block max-w-xs lg:max-w-md px-4 py-3 rounded-2xl shadow-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                            <div class="text-sm leading-relaxed">${data.message.content}</div>
                            <div class="text-xs mt-2 flex items-center justify-between text-blue-100">
                                <span>${new Date().toLocaleTimeString('ru-RU', {hour: '2-digit', minute: '2-digit'})}</span>
                                <i class="fas fa-check ml-2"></i>
                            </div>
                        </div>
                    `;
                        messagesContainer.appendChild(messageDiv);

                        // Прокручиваем к новому сообщению
                        scrollToBottom();
                    } else {
                        alert('Ошибка отправки сообщения');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка отправки сообщения');
                })
                .finally(() => {
                    // Разблокируем кнопку
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-paper-plane text-lg"></i>';
                });
        });
    </script>
@endsection
