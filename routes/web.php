<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Services\WeatherService;

Route::get('/', [WeatherController::class, 'show'])->name('weather.show');
Route::get('/api/clima/{city}', function ($city) {
    $weatherService = app(WeatherService::class);
    return response()->json($weatherService->getCurrentWeather($city));
});