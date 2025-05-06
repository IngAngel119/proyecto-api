<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\UserResponse;

class UserResponseController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'word_id' => 'required|exists:words,id',
            'answer_id' => 'required|exists:answers,id',
        ]);
    
        $alreadyAnswered = UserResponse::where('user_id', auth()->id())
            ->where('word_id', $request->word_id)->exists();
    
        if ($alreadyAnswered) {
            return response()->json(['message' => 'Already answered.'], 403);
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
            'message' => $isCorrect ? '¡Right Answer!' : 'Wrong Answer, keep trying.',
        ]);
    }
}
