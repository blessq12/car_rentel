<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Deal;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function show(Car $car)
    {
        // Проверяем, что авто прошло модерацию
        if (!$car->is_moderated) {
            abort(404);
        }

        // Загружаем связанные данные
        $car->load(['client', 'city', 'deals.reviews']);

        // Получаем отзывы о владельце
        $ownerReviews = $car->client->receivedReviews()
            ->with('reviewer')
            ->latest()
            ->take(5)
            ->get();

        // Похожие авто
        $similarCars = Car::with(['client', 'city'])
            ->where('is_moderated', true)
            ->where('id', '!=', $car->id)
            ->where('city_id', $car->city_id)
            ->where('price_per_day', '>=', $car->price_per_day * 0.8)
            ->where('price_per_day', '<=', $car->price_per_day * 1.2)
            ->take(4)
            ->get();

        return view('cars.show', compact('car', 'ownerReviews', 'similarCars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'fuel_type' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'city_id' => 'required|exists:cities,id',
            'description' => 'nullable|string|max:1000',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // TODO: Добавить client_id из авторизованного пользователя
        $validated['client_id'] = 1; // Временно
        $validated['is_moderated'] = false;
        $validated['is_promoted'] = false;

        $car = Car::create($validated);

        // Загрузка фото
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('cars', 'public');
                // TODO: Сохранить пути к фото в metadata
            }
        }

        return redirect()->route('cars.show', $car)
            ->with('success', 'Объявление создано и отправлено на модерацию');
    }

    public function edit(Car $car)
    {
        // TODO: Проверить права доступа
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        // TODO: Проверить права доступа

        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'fuel_type' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'city_id' => 'required|exists:cities,id',
            'description' => 'nullable|string|max:1000',
        ]);

        $car->update($validated);

        return redirect()->route('cars.show', $car)
            ->with('success', 'Объявление обновлено');
    }
}
