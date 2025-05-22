<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AngelWeather - Clima en {{ $weather['location']['name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .weather-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
    </style>
</head>
<body class="p-6 md:p-12">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <!-- Título -->
        <div class="flex items-center gap-2 w-full md:w-auto justify-center md:justify-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            </svg> 
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 bg-gradient-to-r">
                AngelWeather
            </h1>
        </div>

        <!-- Barra de búsqueda -->
        <form method="GET" action="{{ route('weather.show') }}" class="w-full md:w-auto md:max-w-md md:ml-6">
            <div class="flex">
                <input
                    type="text"
                    name="city"
                    placeholder="Busca una ciudad..."
                    required
                    class="flex-grow p-3 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                />
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 md:px-6 rounded-r-lg hover:bg-blue-700 transition whitespace-nowrap"
                >
                    Buscar
                </button>
            </div>
        </form>
    </div>
    @if ($errors->has('city'))
                <div class="max-w-4xl mx-auto mb-6 p-4 bg-red-100 text-red-700 rounded">
                    {{ $errors->first('city') }}
                </div>
    @endif
    <div class="max-w-4xl mx-auto space-y-10">
        <!-- Fecha -->
        <div class="text-center">
            <p class="text-gray-600 text-lg md:text-xl">{{ now()->format('l, d F Y') }}</p>
        </div>

        <!-- Main Weather Card -->
        <div class="weather-card rounded-2xl p-8 transition-all hover:shadow-xl">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <!-- Location Info -->
                <div class="text-center md:text-left md:flex-1">
                    <h2 class="text-2xl font-semibold text-gray-800 flex items-center justify-center md:justify-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $weather['location']['name'] }}, {{ $weather['location']['region'] }}
                    </h2>
                    <p class="text-gray-600 text-center md:text-left">{{ $weather['location']['country'] }}</p>
                    <p class="text-sm text-gray-500 mt-2 text-center md:text-left">
                        <span class="font-medium">Hora local:</span> {{ date('H:i', strtotime($weather['location']['localtime'])) }}
                    </p>
                </div>

                <!-- Current Weather -->
                <div class="text-center md:flex-1">
                    <div class="flex justify-center items-center">
                        <img src="{{ str_replace('//', 'https://', $weather['current']['condition']['icon']) }}"
                            alt="{{ $weather['current']['condition']['text'] }}"
                            class="w-24 h-24"
                        />
                        <span class="text-6xl font-bold text-gray-800 ml-4">{{ round($weather['current']['temp_c']) }}°C</span>
                    </div>
                    <p class="text-2xl capitalize mt-2">{{ $weather['current']['condition']['text'] }}</p>
                </div>
            </div>

            <!-- Weather Details -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
                <div class="bg-white bg-opacity-60 p-5 rounded-lg text-center shadow-sm">
                    <p class="text-gray-600 mb-1">Sensación térmica</p>
                    <p class="text-2xl font-semibold">{{ round($weather['current']['feelslike_c']) }}°C</p>
                </div>
                <div class="bg-white bg-opacity-60 p-5 rounded-lg text-center shadow-sm">
                    <p class="text-gray-600 mb-1">Humedad</p>
                    <p class="text-2xl font-semibold">{{ $weather['current']['humidity'] }}%</p>
                </div>
                <div class="bg-white bg-opacity-60 p-5 rounded-lg text-center shadow-sm">
                    <p class="text-gray-600 mb-1">Viento</p>
                    <p class="text-2xl font-semibold">{{ $weather['current']['wind_kph'] }} km/h</p>
                </div>
                <div class="bg-white bg-opacity-60 p-5 rounded-lg text-center shadow-sm">
                    <p class="text-gray-600 mb-1">Presión</p>
                    <p class="text-2xl font-semibold">{{ $weather['current']['pressure_mb'] }} mb</p>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Amanecer/Atardecer -->
            <div class="weather-card p-6 rounded-2xl shadow-md">
                <h3 class="text-xl font-semibold mb-5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Amanecer / Atardecer
                </h3>
                <div class="flex justify-around text-center">
                    <div>
                        <p class="text-gray-600 mb-1">Amanecer</p>
                        <p class="text-lg font-medium">06:45 AM</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Atardecer</p>
                        <p class="text-lg font-medium">06:30 PM</p>
                    </div>
                </div>
            </div>

            <!-- Índice UV -->
            <div class="weather-card p-6 rounded-2xl shadow-md">
                <h3 class="text-xl font-semibold mb-5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Índice UV
                </h3>
                <div class="flex items-center gap-4">
                    <span class="text-3xl font-bold">{{ $weather['current']['uv'] }}</span>
                    <span
                        class="px-4 py-1 rounded-full text-sm font-medium
                        @if($weather['current']['uv'] <= 2) bg-green-100 text-green-800
                        @elseif($weather['current']['uv'] <= 5) bg-yellow-100 text-yellow-800
                        @elseif($weather['current']['uv'] <= 7) bg-orange-100 text-orange-800
                        @else bg-red-100 text-red-800 @endif"
                    >
                        @if($weather['current']['uv'] <= 2) Bajo
                        @elseif($weather['current']['uv'] <= 5) Moderado
                        @elseif($weather['current']['uv'] <= 7) Alto
                        @else Extremo @endif
                    </span>
                </div>
                <p class="text-sm text-gray-600 mt-3 max-w-sm">
                    @if($weather['current']['uv'] <= 2) No se requiere protección
                    @elseif($weather['current']['uv'] <= 5) Usa protector solar
                    @elseif($weather['current']['uv'] <= 7) Protección extra necesaria
                    @else Evita la exposición al sol @endif
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center mt-12 text-sm text-gray-500">
            <p>Datos proporcionados por WeatherAPI.com</p>
            <p class="mt-1">Actualizado: {{ $weather['current']['last_updated'] }}</p>
        </footer>
    </div>
</body>
</html>