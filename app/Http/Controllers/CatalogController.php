<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\City;
use App\Enums\FuelType;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
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

        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        if ($request->filled('year_min')) {
            $query->where('year', '>=', $request->year_min);
        }

        if ($request->filled('year_max')) {
            $query->where('year', '<=', $request->year_max);
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->filled('price_min')) {
            $query->where('price_per_day', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_day', '<=', $request->price_max);
        }

        // Сортировка
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_day', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_day', 'desc');
                break;
            case 'rating':
                $query->orderBy('client.rating', 'desc');
                break;
            default:
                $query->latest();
        }

        $cars = $query->paginate(12)->withQueryString();

        // Данные для фильтров
        $cities = City::where('is_active', true)->get();
        $fuelTypes = FuelType::cases();
        $brands = Car::distinct()->pluck('brand')->sort();

        return view('catalog.index', compact('cars', 'cities', 'fuelTypes', 'brands'));
    }
}
