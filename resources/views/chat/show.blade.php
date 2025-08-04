@extends('layouts.app')

@section('title', 'Чат - CarRental')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Заголовок чата -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>

                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            @if ($chat->deal && $chat->deal->car)
                                {{ $chat->deal->car->brand }} {{ $chat->deal->car->model }}
                            @else
                                Чат #{{ $chat->id }}
                            @endif
                        </h1>
                        <p class="text-gray-600">
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
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-eye mr-2"></i>Просмотр сделки
                    </a>
                @endif
            </div>
        </div>

        <!-- Сообщения -->
        <div class="bg-white rounded-lg shadow-md h-96 flex flex-col">
            <!-- Область сообщений -->
            <div class="flex-1 overflow-y-auto p-6" id="messages-container">
                @if ($messages->count() > 0)
                    @foreach ($messages as $message)
                        <div
                            class="mb-4 {{ $message->sender_id === (auth()->user()->client->id ?? 0) ? 'text-right' : 'text-left' }}">
                            <div
                                class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_id === (auth()->user()->client->id ?? 0) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-900' }}">
                                <div class="text-sm">
                                    {{ $message->content }}
                                </div>
                                <div
                                    class="text-xs mt-1 {{ $message->sender_id === (auth()->user()->client->id ?? 0) ? 'text-blue-100' : 'text-gray-500' }}">
                                    {{ $message->created_at->format('H:i') }}
                                    @if ($message->sender_id === (auth()->user()->client->id ?? 0))
                                        @if ($message->is_read)
                                            <i class="fas fa-check-double ml-1"></i>
                                        @else
                                            <i class="fas fa-check ml-1"></i>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-comments text-4xl mb-4"></i>
                        <p>Начните общение</p>
                    </div>
                @endif
            </div>

            <!-- Форма отправки сообщения -->
            <div class="border-t border-gray-200 p-4">
                <form id="message-form" class="flex space-x-4">
                    @csrf
                    <input type="hidden" name="chat_id" value="{{ $chat->id }}">

                    <div class="flex-1">
                        <textarea name="content" rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Введите сообщение..." required></textarea>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
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
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

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
                        <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg bg-blue-600 text-white">
                            <div class="text-sm">${data.message.content}</div>
                            <div class="text-xs mt-1 text-blue-100">
                                ${new Date().toLocaleTimeString('ru-RU', {hour: '2-digit', minute: '2-digit'})}
                                <i class="fas fa-check ml-1"></i>
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
                    submitButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
                });
        });
    </script>
@endsection
