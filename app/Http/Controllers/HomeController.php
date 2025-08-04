<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\City;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Получаем популярные автомобили (продвигаемые)
        $popularCars = Car::with(['client', 'city'])
            ->where('is_promoted', true)
            ->where('is_moderated', true)
            ->latest()
            ->take(6)
            ->get();

        // Получаем города для поиска
        $cities = City::where('is_active', true)->get();

        return view('home.index', compact('popularCars', 'cities'));
    }

    public function search(Request $request)
    {
        $query = Car::with(['client', 'city'])
            ->where('is_moderated', true);

        // Фильтры
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->filled('price_min')) {
            $query->where('price_per_day', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_day', '<=', $request->price_max);
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        $cars = $query->latest()->paginate(12);

        return view('catalog.index', compact('cars'));
    }
}
