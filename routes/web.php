<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisputeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PageController;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Статические страницы
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Каталог
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

// Автомобили
Route::get('/cars', [CarController::class, 'create'])->name('cars.create');
Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');

// Сделки
Route::get('/deals/{deal}', [DealController::class, 'show'])->name('deals.show');

// Отзывы
Route::prefix('reviews')->name('reviews.')->group(function () {
    Route::get('/create', [ReviewController::class, 'create'])->name('create');
    Route::post('/', [ReviewController::class, 'store'])->name('store');
});

// Профиль
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('update');
    Route::get('/cars', [ProfileController::class, 'cars'])->name('cars');
    Route::get('/deals', [ProfileController::class, 'deals'])->name('deals');
    Route::get('/rentals', [ProfileController::class, 'rentals'])->name('rentals');
    Route::get('/reviews', [ProfileController::class, 'reviews'])->name('reviews');
});

// Чаты
Route::prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/{chat}', [ChatController::class, 'show'])->name('show');
    Route::post('/{chat}/messages', [ChatController::class, 'store'])->name('messages.store');
    Route::post('/send', [ChatController::class, 'send'])->name('send');
    Route::post('/create', [ChatController::class, 'create'])->name('create');
});

// Авторизация
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/telegram', [AuthController::class, 'telegram'])->name('telegram');
    Route::post('/telegram/callback', [AuthController::class, 'telegramCallback'])->name('telegram.callback');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Споры
Route::prefix('disputes')->name('disputes.')->group(function () {
    Route::get('/', [DisputeController::class, 'index'])->name('index');
    Route::get('/create', [DisputeController::class, 'create'])->name('create');
    Route::post('/', [DisputeController::class, 'store'])->name('store');
    Route::get('/{dispute}', [DisputeController::class, 'show'])->name('show');
    Route::get('/{dispute}/edit', [DisputeController::class, 'edit'])->name('edit');
    Route::put('/{dispute}', [DisputeController::class, 'update'])->name('update');
});
