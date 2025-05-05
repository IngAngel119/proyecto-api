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
    public function showCategory()
    {
        return response()->json(Category::all());
    }

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
    
    public function dailyWord(Request $request)
    {
    	$request->validate([
       		 'category_id' => 'required|exists:categories,id',
    	]);

    	$userId = auth()->id();
    	$today = now()->toDateString();
	
    	// Verifica si el usuario ya respondió hoy en esa categoría
    	$alreadyAnswered = UserResponse::where('user_id', $userId)
        	->whereDate('created_at', $today)
        	->whereHas('word', function ($q) use ($request) {
            	$q->where('category_id', $request->category_id);
        	})
        	->exists();

    	if ($alreadyAnswered) {
        	return response()->json(['message' => 'Ya respondiste hoy en esta categoría'], 403);
    	}

    	// Selecciona palabra aleatoria de la categoría
    	$word = Word::with('answers', 'category')
        	->where('category_id', $request->category_id)
        	->inRandomOrder()
        	->first();

    	if (!$word) {
        	return response()->json(['message' => 'No hay palabras en esta categoría'], 404);
    	}

    	return response()->json([
        	'category' => $word->category->name,
        	'word' => $word,
    	]);
        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $userId = auth()->id();
        $today = now()->toDateString();

        // Verifica si el usuario ya respondió hoy en esa categoría
        $alreadyAnswered = UserResponse::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->whereHas('word', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->exists();

        if ($alreadyAnswered) {
            return response()->json(['message' => 'Ya respondiste hoy en esta categoría'], 403);
        }

        // Selecciona palabra aleatoria de la categoría
        $word = Word::with('answers', 'category')
            ->where('category_id', $request->category_id)
            ->inRandomOrder()
            ->first();

        if (!$word) {
            return response()->json(['message' => 'No hay palabras en esta categoría'], 404);
        }

        return response()->json([
            'category' => $word->category->name,
            'word' => $word,
        ]);
    }
  


}
