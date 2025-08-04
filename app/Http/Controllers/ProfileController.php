<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Car;
use App\Models\Deal;
use App\Models\Review;
use App\Models\Dispute;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $client = \App\Http\Controllers\AuthController::getCurrentClient();

        if (!$client) {
            return redirect()->route('auth.login')
                ->withErrors(['auth' => 'Необходимо войти в систему.']);
        }

        // Определяем тип пользователя
        $isOwner = $client->cars()->count() > 0;

        if ($isOwner) {
            return $this->ownerDashboard($client);
        } else {
            return $this->renterDashboard($client);
        }
    }

    private function ownerDashboard($client)
    {
        $myCars = $client->cars()->latest()->get();
        $myDeals = $client->deals()->with(['car', 'renter'])->latest()->get();
        $myReviews = $client->reviews()->with(['reviewed', 'deal'])->latest()->get();
        $myDisputes = $client->disputes()->union($client->respondentDisputes())->latest()->get();
        $earnings = $myDeals->where('status', 'completed')->sum('total_price');

        return view('profile.owner', compact('client', 'myCars', 'myDeals', 'myReviews', 'myDisputes', 'earnings'));
    }

    private function renterDashboard($client)
    {
        $myRentals = $client->rentals()->with(['car', 'client'])->latest()->get();
        $myReviews = $client->reviews()->with(['reviewed', 'deal'])->latest()->get();
        $myDisputes = $client->disputes()->union($client->respondentDisputes())->latest()->get();
        $totalSpent = $myRentals->where('status', 'completed')->sum('total_price');

        return view('profile.renter', compact('client', 'myRentals', 'myReviews', 'myDisputes', 'totalSpent'));
    }

    public function edit()
    {
        $client = \App\Http\Controllers\AuthController::getCurrentClient();

        if (!$client) {
            return redirect()->route('auth.login')
                ->withErrors(['auth' => 'Необходимо войти в систему.']);
        }

        return view('profile.edit', compact('client'));
    }

    public function update(Request $request)
    {
        $client = \App\Http\Controllers\AuthController::getCurrentClient();

        if (!$client) {
            return redirect()->route('auth.login')
                ->withErrors(['auth' => 'Необходимо войти в систему.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telegram_nickname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        $client->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Профиль обновлен');
    }

    public function cars()
    {
        $client = \App\Http\Controllers\AuthController::getCurrentClient();

        if (!$client) {
            return redirect()->route('auth.login')
                ->withErrors(['auth' => 'Необходимо войти в систему.']);
        }

        // Проверяем, что это арендодатель
        if ($client->cars()->count() === 0) {
            return redirect()->route('profile.index')
                ->withErrors(['auth' => 'Эта страница доступна только арендодателям.']);
        }

        $cars = $client->cars()->latest()->paginate(10);

        return view('profile.cars', compact('cars'));
    }

    public function rentals()
    {
        $client = \App\Http\Controllers\AuthController::getCurrentClient();

        if (!$client) {
            return redirect()->route('auth.login')
                ->withErrors(['auth' => 'Необходимо войти в систему.']);
        }

        $rentals = $client->rentals()->with(['car', 'client'])->latest()->paginate(10);

        return view('profile.rentals', compact('rentals'));
    }

    public function deals()
    {
        $client = \App\Http\Controllers\AuthController::getCurrentClient();

        if (!$client) {
            return redirect()->route('auth.login')
                ->withErrors(['auth' => 'Необходимо войти в систему.']);
        }

        // Проверяем, что это арендодатель
        if ($client->cars()->count() === 0) {
            return redirect()->route('profile.index')
                ->withErrors(['auth' => 'Эта страница доступна только арендодателям.']);
        }

        $deals = $client->deals()->with(['car', 'renter'])->latest()->paginate(10);

        return view('profile.deals', compact('deals'));
    }

    public function reviews()
    {
        $client = \App\Http\Controllers\AuthController::getCurrentClient();

        if (!$client) {
            return redirect()->route('auth.login')
                ->withErrors(['auth' => 'Необходимо войти в систему.']);
        }

        $reviews = $client->reviews()->with(['reviewed', 'deal'])->latest()->paginate(10);
        $receivedReviews = $client->receivedReviews()->with(['reviewer', 'deal'])->latest()->paginate(10);

        return view('profile.reviews', compact('reviews', 'receivedReviews'));
    }
}
