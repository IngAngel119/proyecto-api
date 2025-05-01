<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Category;

class WordSeeder extends Seeder
{
    public function run()
    {
        // Crear 5 categorías específicas
        $categories = [
            'Animales',
            'Tecnología',
            'Geografía',
            'Alimentos',
            'Deportes'
        ];

        $categoryIds = [];

        foreach ($categories as $name) {
            $categoryIds[] = Category::firstOrCreate(['name' => $name])->id;
        }

        // Datos de palabras (50) con categoría relacionada
        $words = [
            // Animales (10)
            ['definition' => 'Animal que dice miau', 'correct' => 'Gato', 'options' => ['Perro', 'Ratón', 'Caballo'], 'category' => 'Animales'],
            ['definition' => 'Animal que ladra', 'correct' => 'Perro', 'options' => ['Gato', 'Pato', 'Ratón'], 'category' => 'Animales'],
            ['definition' => 'Animal más grande del mundo', 'correct' => 'Ballena azul', 'options' => ['Elefante', 'Tiburón blanco', 'Jirafa'], 'category' => 'Animales'],
            ['definition' => 'Animal que produce miel', 'correct' => 'Abeja', 'options' => ['Avispa', 'Hormiga', 'Mariposa'], 'category' => 'Animales'],
            ['definition' => 'Reptil que cambia de color', 'correct' => 'Camaleón', 'options' => ['Iguana', 'Cocodrilo', 'Tortuga'], 'category' => 'Animales'],
            ['definition' => 'Animal más rápido en tierra', 'correct' => 'Guepardo', 'options' => ['León', 'Caballo', 'Perro'], 'category' => 'Animales'],
            ['definition' => 'Mamífero que pone huevos', 'correct' => 'Ornitorrinco', 'options' => ['Murciélago', 'Delfín', 'Canguro'], 'category' => 'Animales'],
            ['definition' => 'Ave que no vuela de Nueva Zelanda', 'correct' => 'Kiwi', 'options' => ['Pingüino', 'Avestruz', 'Gallina'], 'category' => 'Animales'],
            ['definition' => 'Animal nacional de Australia', 'correct' => 'Canguro', 'options' => ['Koala', 'Emú', 'Dingo'], 'category' => 'Animales'],
            ['definition' => 'Insecto que brilla en la oscuridad', 'correct' => 'Luciérnaga', 'options' => ['Araña', 'Escarabajo', 'Grillo'], 'category' => 'Animales'],

            // Tecnología (10)
            ['definition' => 'Lenguaje usado en este archivo', 'correct' => 'PHP', 'options' => ['JavaScript', 'Python', 'Ruby'], 'category' => 'Tecnología'],
            ['definition' => 'Creador de Facebook', 'correct' => 'Mark Zuckerberg', 'options' => ['Bill Gates', 'Steve Jobs', 'Elon Musk'], 'category' => 'Tecnología'],
            ['definition' => 'Sistema operativo de código abierto', 'correct' => 'Linux', 'options' => ['Windows', 'macOS', 'iOS'], 'category' => 'Tecnología'],
            ['definition' => 'Dispositivo para hacer llamadas', 'correct' => 'Teléfono', 'options' => ['Televisor', 'Lavadora', 'Cámara'], 'category' => 'Tecnología'],
            ['definition' => 'Empresa creadora del iPhone', 'correct' => 'Apple', 'options' => ['Samsung', 'Google', 'Microsoft'], 'category' => 'Tecnología'],
            ['definition' => 'Red social de videos cortos', 'correct' => 'TikTok', 'options' => ['Instagram', 'Twitter', 'Facebook'], 'category' => 'Tecnología'],
            ['definition' => 'Lenguaje para diseñar páginas web', 'correct' => 'HTML', 'options' => ['Python', 'Java', 'C++'], 'category' => 'Tecnología'],
            ['definition' => 'Dispositivo de almacenamiento portátil', 'correct' => 'USB', 'options' => ['CD', 'Disco duro', 'Tarjeta SD'], 'category' => 'Tecnología'],
            ['definition' => 'Navegador web de Google', 'correct' => 'Chrome', 'options' => ['Firefox', 'Safari', 'Edge'], 'category' => 'Tecnología'],
            ['definition' => 'Inteligencia artificial de OpenAI', 'correct' => 'ChatGPT', 'options' => ['Alexa', 'Siri', 'Google Assistant'], 'category' => 'Tecnología'],

            // Geografía (10)
            ['definition' => 'Capital de Francia', 'correct' => 'París', 'options' => ['Roma', 'Madrid', 'Londres'], 'category' => 'Geografía'],
            ['definition' => 'País más grande del mundo', 'correct' => 'Rusia', 'options' => ['Canadá', 'China', 'EE.UU.'], 'category' => 'Geografía'],
            ['definition' => 'Río más largo del mundo', 'correct' => 'Amazonas', 'options' => ['Nilo', 'Yangtsé', 'Misisipi'], 'category' => 'Geografía'],
            ['definition' => 'Montaña más alta del mundo', 'correct' => 'Everest', 'options' => ['K2', 'Kilimanjaro', 'Aconcagua'], 'category' => 'Geografía'],
            ['definition' => 'Desierto más grande del mundo', 'correct' => 'Sahara', 'options' => ['Gobi', 'Arabia', 'Kalahari'], 'category' => 'Geografía'],
            ['definition' => 'Capital de Japón', 'correct' => 'Tokio', 'options' => ['Kioto', 'Osaka', 'Hiroshima'], 'category' => 'Geografía'],
            ['definition' => 'Océano más grande', 'correct' => 'Pacífico', 'options' => ['Atlántico', 'Índico', 'Ártico'], 'category' => 'Geografía'],
            ['definition' => 'País con forma de bota', 'correct' => 'Italia', 'options' => ['España', 'Grecia', 'Francia'], 'category' => 'Geografía'],
            ['definition' => 'Capital de Canadá', 'correct' => 'Ottawa', 'options' => ['Toronto', 'Vancouver', 'Montreal'], 'category' => 'Geografía'],
            ['definition' => 'País donde se encuentra el Taj Mahal', 'correct' => 'India', 'options' => ['Pakistán', 'Bangladesh', 'Nepal'], 'category' => 'Geografía'],

            // Alimentos (10)
            ['definition' => 'Fruta amarilla que se pela', 'correct' => 'Plátano', 'options' => ['Manzana', 'Uva', 'Fresa'], 'category' => 'Alimentos'],
            ['definition' => 'Pasta italiana en forma de tubo', 'correct' => 'Penne', 'options' => ['Spaghetti', 'Fusilli', 'Farfalle'], 'category' => 'Alimentos'],
            ['definition' => 'Bebida fermentada de uva', 'correct' => 'Vino', 'options' => ['Cerveza', 'Sidra', 'Whisky'], 'category' => 'Alimentos'],
            ['definition' => 'Origen de la paella', 'correct' => 'Valencia', 'options' => ['Barcelona', 'Madrid', 'Sevilla'], 'category' => 'Alimentos'],
            ['definition' => 'Ingrediente principal del hummus', 'correct' => 'Garbanzos', 'options' => ['Lentejas', 'Alubias', 'Guisantes'], 'category' => 'Alimentos'],
            ['definition' => 'Fruto seco del nogal', 'correct' => 'Nuez', 'options' => ['Avellana', 'Almendra', 'Castaña'], 'category' => 'Alimentos'],
            ['definition' => 'Bebida caliente hecha con granos', 'correct' => 'Café', 'options' => ['Té', 'Chocolate', 'Mate'], 'category' => 'Alimentos'],
            ['definition' => 'País originario del sushi', 'correct' => 'Japón', 'options' => ['China', 'Corea', 'Tailandia'], 'category' => 'Alimentos'],
            ['definition' => 'Carne utilizada en un hamburguesa', 'correct' => 'Ternera', 'options' => ['Pollo', 'Cerdo', 'Cordero'], 'category' => 'Alimentos'],
            ['definition' => 'Verdura verde con hojas crujientes', 'correct' => 'Lechuga', 'options' => ['Espinaca', 'Col', 'Acelga'], 'category' => 'Alimentos'],

            // Deportes (10)
            ['definition' => 'Deporte con raqueta y pelota amarilla', 'correct' => 'Tenis', 'options' => ['Bádminton', 'Squash', 'Pádel'], 'category' => 'Deportes'],
            ['definition' => 'Deporte nacional de EE.UU.', 'correct' => 'Béisbol', 'options' => ['Fútbol americano', 'Baloncesto', 'Hockey'], 'category' => 'Deportes'],
            ['definition' => 'Jugador de fútbol con más Balones de Oro', 'correct' => 'Messi', 'options' => ['Cristiano Ronaldo', 'Pelé', 'Maradona'], 'category' => 'Deportes'],
            ['definition' => 'Deporte en el que se usa un puck', 'correct' => 'Hockey', 'options' => ['Fútbol', 'Rugby', 'Waterpolo'], 'category' => 'Deportes'],
            ['definition' => 'País ganador del Mundial 2018', 'correct' => 'Francia', 'options' => ['Croacia', 'Brasil', 'Alemania'], 'category' => 'Deportes'],
            ['definition' => 'Deporte con caballos y pelota', 'correct' => 'Polo', 'options' => ['Hípica', 'Turf', 'Equitación'], 'category' => 'Deportes'],
            ['definition' => 'Deporte de raqueta más rápido', 'correct' => 'Bádminton', 'options' => ['Tenis', 'Squash', 'Ping-pong'], 'category' => 'Deportes'],
            ['definition' => 'Nadador con más medallas olímpicas', 'correct' => 'Michael Phelps', 'options' => ['Mark Spitz', 'Ian Thorpe', 'Ryan Lochte'], 'category' => 'Deportes'],
            ['definition' => 'Deporte con strikes y home runs', 'correct' => 'Béisbol', 'options' => ['Cricket', 'Softball', 'Rugby'], 'category' => 'Deportes'],
            ['definition' => 'Deporte nacional de Canadá', 'correct' => 'Lacrosse', 'options' => ['Hockey', 'Curling', 'Béisbol'], 'category' => 'Deportes'],
        ];

        foreach ($words as $index => $data) {
            $categoryId = $categoryIds[array_search($data['category'], $categories)];
            
            $word = Word::create([
                'definition' => $data['definition'],
                'category_id' => $categoryId,
            ]);

            $options = $data['options'];
            $options[] = $data['correct'];
            shuffle($options);

            foreach ($options as $option) {
                $word->answers()->create([
                    'text' => $option,
                    'is_correct' => $option === $data['correct'],
                ]);
            }
        }
    }
}
