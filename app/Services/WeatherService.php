<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class WeatherService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('WEATHER_API_KEY');
    }

    public function getCurrentWeather(string $city)
    {
        try {
            $response = $this->client->get("http://api.weatherapi.com/v1/current.json", [
                'query' => [
                    'key' => $this->apiKey,
                    'q' => $city,
                    'lang' => 'es'
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}