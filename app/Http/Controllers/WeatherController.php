<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request; 

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show(Request $request)
    {
        $city = $request->query('city', 'Mexico');
        $weather = $this->weatherService->getCurrentWeather($city);

        // Verificar si $weather tiene datos válidos
        if (!isset($weather['location']) || empty($weather['location'])) {
            return redirect()->back()->withErrors(['city' => 'La ciudad no fue encontrada. Por favor, intenta con otra.']);
        }

        return view('weather', ['weather' => $weather]);
    }


}