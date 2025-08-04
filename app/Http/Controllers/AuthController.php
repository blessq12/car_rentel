<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        $cities = City::where('is_active', true)->get();
        return view('auth.register', compact('cities'));
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Временная логика для тестовых пользователей
        $testUsers = [
            'owner@test.com' => 'password',
            'renter@test.com' => 'password',
        ];

        if (isset($testUsers[$validated['email']]) && $testUsers[$validated['email']] === $validated['password']) {
            $client = Client::where('email', $validated['email'])->first();
            
            if ($client) {
                // Сохраняем пользователя в сессии
                session(['auth_client_id' => $client->id]);
                session(['auth_client_name' => $client->name]);
                session(['auth_client_email' => $client->email]);
                
                return redirect()->intended('/profile')
                    ->with('success', 'Добро пожаловать, ' . $client->name . '!');
            }
        }

        // Стандартная аутентификация (пока не используется)
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Неверные данные для входа.',
        ])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'telegram_nickname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $client = Client::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telegram_nickname' => $validated['telegram_nickname'],
            'phone' => $validated['phone'],
            'city_id' => $validated['city_id'],
            'rating' => 0,
            'dispute_count' => 0,
            'is_verified' => false,
        ]);

        // TODO: Создать пользователя в системе аутентификации
        // Auth::login($user);

        return redirect()->route('auth.telegram')
            ->with('success', 'Регистрация успешна. Подтвердите через Telegram.');
    }

    public function telegram()
    {
        return view('auth.telegram');
    }

    public function telegramCallback(Request $request)
    {
        // TODO: Обработка callback от Telegram Bot API
        $telegramData = $request->all();

        // Найти клиента по telegram_id или username
        $client = Client::where('telegram_nickname', $telegramData['username'] ?? null)
            ->first();

        if ($client) {
            $client->update([
                'is_verified' => true,
                'metadata' => array_merge($client->metadata ?? [], [
                    'telegram_id' => $telegramData['id'] ?? null,
                    'telegram_verified_at' => now(),
                ]),
            ]);

            // TODO: Авторизовать пользователя
            // Auth::login($client);

            return redirect()->route('profile.index')
                ->with('success', 'Telegram успешно подключен!');
        }

        return redirect()->route('auth.login')
            ->withErrors(['telegram' => 'Пользователь не найден.']);
    }

    public function logout(Request $request)
    {
        // Очищаем сессию для тестовых пользователей
        session()->forget(['auth_client_id', 'auth_client_name', 'auth_client_email']);
        
        // Стандартный logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Вы успешно вышли из системы.');
    }

    // Вспомогательный метод для получения текущего пользователя
    public static function getCurrentClient()
    {
        $clientId = session('auth_client_id');
        return $clientId ? Client::find($clientId) : null;
    }
}
