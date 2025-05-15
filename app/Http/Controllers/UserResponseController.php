<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Answer;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use App\Models\UserResponse;

class UserResponseController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'word_id' => 'required|exists:words,id',
            'answer_id' => 'required|exists:answers,id',
        ]);
    
        $user = auth()->user();
    
        // Verificar si la respuesta pertenece a la palabra
        $answerBelongsToWord = Answer::where('id', $request->answer_id)
                                    ->where('word_id', $request->word_id)
                                    ->exists();
    
        if (!$answerBelongsToWord) {
            return response()->json(['message' => 'This answer does not belong to the word provided.'], 422);
        }
    
        $alreadyAnswered = UserResponse::where('user_id', $user->id)
            ->where('word_id', $request->word_id)->exists();
    
        if ($alreadyAnswered) {
            History::create([
                'user_name' => $user->name,
                'word' => Word::find($request->word_id)->text,
                'event' => History::EVENT_ALREADY_ANSWERED
            ]);
            
            return response()->json(['message' => 'Already answered.'], 403);
        }
    
        // Obtener la palabra y su respuesta correcta
        $word = Word::with('correctAnswer')->findOrFail($request->word_id);
        $isCorrect = $word->correctAnswer && $word->correctAnswer->id == $request->answer_id;
    
        // Guardar la respuesta del usuario
        UserResponse::create([
            'user_id' => $user->id,
            'word_id' => $request->word_id,
            'answer_id' => $request->answer_id,
        ]);
    
        // Registrar el evento en el historial
        $event = $isCorrect ? History::EVENT_ANSWER_CORRECT : History::EVENT_ANSWER_WRONG;
        
        History::create([
            'user_name' => $user->name,
            'word' => $word->text,
            'event' => $event
        ]);
    
        return response()->json([
            'correct' => $isCorrect,
            'message' => $isCorrect ? '¡Right Answer!' : 'Wrong Answer, keep trying.',
        ]);
    }
}
