<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Deal;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // TODO: Получить авторизованного клиента
        $clientId = 1; // Временно

        $chats = Chat::where('client_id', $clientId)
            ->orWhere('renter_id', $clientId)
            ->with(['deal.car', 'deal.client', 'deal.renter', 'messages'])
            ->latest()
            ->paginate(10);

        return view('chat.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        // TODO: Проверить права доступа к чату
        $clientId = 1; // Временно

        if ($chat->client_id != $clientId && $chat->renter_id != $clientId) {
            abort(403);
        }

        $chat->load(['deal.car', 'deal.client', 'deal.renter', 'messages.client']);

        $messages = $chat->messages()->with('client')->latest()->paginate(20);

        return view('chat.show', compact('chat', 'messages'));
    }

    public function store(Request $request, Chat $chat)
    {
        // TODO: Проверить права доступа к чату
        $clientId = 1; // Временно

        if ($chat->client_id != $clientId && $chat->renter_id != $clientId) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'type' => 'required|in:text,image,video',
        ]);

        $message = $chat->messages()->create([
            'client_id' => $clientId,
            'content' => $validated['content'],
            'type' => $validated['type'],
        ]);

        // TODO: Отправить уведомление через Telegram

        return response()->json($message);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string|max:1000',
        ]);

        // TODO: Получить авторизованного клиента
        $clientId = 1; // Временно

        $chat = Chat::findOrFail($validated['chat_id']);

        // Проверяем права доступа к чату
        if ($chat->client_id != $clientId && $chat->renter_id != $clientId) {
            abort(403);
        }

        $message = $chat->messages()->create([
            'sender_id' => $clientId,
            'content' => $validated['content'],
            'type' => 'text',
            'is_read' => false,
        ]);

        // TODO: Отправить уведомление через Telegram

        return response()->json([
            'success' => true,
            'message' => $message->load('client')
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'deal_id' => 'required|exists:deals,id',
            'message' => 'required|string|max:1000',
        ]);

        $deal = Deal::findOrFail($validated['deal_id']);

        // TODO: Получить авторизованного клиента
        $clientId = 1; // Временно

        // Создаем или находим чат
        $chat = Chat::firstOrCreate([
            'deal_id' => $deal->id,
        ], [
            'client_id' => $deal->client_id,
            'renter_id' => $deal->renter_id,
        ]);

        // Создаем сообщение
        $message = $chat->messages()->create([
            'client_id' => $clientId,
            'content' => $validated['message'],
            'type' => 'text',
        ]);

        // TODO: Отправить уведомление через Telegram

        return redirect()->route('chat.show', $chat)
            ->with('success', 'Сообщение отправлено');
    }
}
