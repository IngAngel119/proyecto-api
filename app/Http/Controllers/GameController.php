<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Word;
use App\Models\UserResponse;
use App\Models\Answer;
use App\Models\Category;

class GameController extends Controller
{   
    public function answer(Request $request) {
        $request->validate([
            'word_id' => 'required|exists:words,id',
            'answer_id' => 'required|exists:answers,id',
        ]);
    
        $alreadyAnswered = UserResponse::where('user_id', auth()->id())
            ->where('word_id', $request->word_id)->exists();
    
        if ($alreadyAnswered) {
            return response()->json(['message' => 'Already answered today'], 403);
        }
    
        // Obtener la palabra y su respuesta correcta
        $word = Word::with('correctAnswer')->findOrFail($request->word_id);
        $isCorrect = $word->correctAnswer && $word->correctAnswer->id == $request->answer_id;
    
        // Guardar la respuesta del usuario
        UserResponse::create([
            'user_id' => auth()->id(),
            'word_id' => $request->word_id,
            'answer_id' => $request->answer_id,
        ]);
    
        // Respuesta personalizada
        return response()->json([
            'correct' => $isCorrect,
            'message' => $isCorrect ? '¡Respuesta correcta!' : 'Respuesta incorrecta, sigue intentando.',
        ]);
    }
    
    public function dailyWord()
    {
        $categoryCount = Category::count();

        if ($categoryCount === 0) {
            return response()->json(['message' => 'No hay categorías disponibles'], 404);
        }

        $dayIndex = now()->dayOfYear % $categoryCount;

        $category = \App\Models\Category::skip($dayIndex)->take(1)->first();

        $word = $category->words()->with('answers')->inRandomOrder()->first();

        if (!$word) {
            return response()->json(['message' => 'No hay palabra para hoy en esta categoría'], 404);
        }

        return response()->json([
            'category' => $category->name,
            'word' => $word,
        ]);
    }

}
