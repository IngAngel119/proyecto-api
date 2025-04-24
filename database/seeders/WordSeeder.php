<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Category;

class WordSeeder extends Seeder
{
    public function run()
    {
        // Crear categorías base
        $categories = [
            'Animales',
            'Colores',
            'Astronomía',
            'Objetos',
            'Estaciones',
            'Frutas',
            'Tecnología',
            'Lenguajes de programación',
            'Capitales',
            'Dispositivos',
        ];

        $categoryIds = [];

        foreach ($categories as $name) {
            $categoryIds[] = Category::firstOrCreate(['name' => $name])->id;
        }

        // Datos de palabras con categoría relacionada
        $words = [
            ['definition' => 'Animal que dice miau', 'correct' => 'Gato', 'options' => ['Perro', 'Ratón', 'Caballo']],
            ['definition' => 'Color del cielo en un día despejado', 'correct' => 'Azul', 'options' => ['Rojo', 'Verde', 'Amarillo']],
            ['definition' => 'Planeta en el que vivimos', 'correct' => 'Tierra', 'options' => ['Marte', 'Venus', 'Júpiter']],
            ['definition' => 'Objeto que sirve para escribir', 'correct' => 'Lápiz', 'options' => ['Cuchara', 'Martillo', 'Cepillo']],
            ['definition' => 'Estación del año con nieve', 'correct' => 'Invierno', 'options' => ['Verano', 'Otoño', 'Primavera']],
            ['definition' => 'Fruta amarilla que se pela', 'correct' => 'Plátano', 'options' => ['Manzana', 'Uva', 'Fresa']],
            ['definition' => 'Animal que ladra', 'correct' => 'Perro', 'options' => ['Gato', 'Pato', 'Ratón']],
            ['definition' => 'Lenguaje usado en este archivo', 'correct' => 'PHP', 'options' => ['JavaScript', 'Python', 'Ruby']],
            ['definition' => 'Capital de Francia', 'correct' => 'París', 'options' => ['Roma', 'Madrid', 'Londres']],
            ['definition' => 'Dispositivo para hacer llamadas', 'correct' => 'Teléfono', 'options' => ['Televisor', 'Lavadora', 'Cámara']],
        ];

        foreach ($words as $index => $data) {
            $word = Word::create([
                'date' => now()->addDays($index)->format('Y-m-d'),
                'definition' => $data['definition'],
                'category_id' => $categoryIds[$index % count($categoryIds)], // Asignar categoría de forma circular
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
