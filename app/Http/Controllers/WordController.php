<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\UserResponse;
use Illuminate\Validation\Rule;

class WordController extends Controller
{
    public function dailyWord(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
        ], [
            'category_id.exists' => ':input', // Mensaje personalizado
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'The selected category id is invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

    	$userId = auth()->id();
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();
	
    	// Verifica si el usuario ya respondió hoy en esa categoría
    	$alreadyAnswered = UserResponse::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
        	->whereHas('word', function ($q) use ($request) {
            	$q->where('category_id', $request->category_id);
        	})
        	->exists();

    	if ($alreadyAnswered) {
        	return response()->json(['message' => 'You already answered in this category today'], 403);
    	}

    	// Selecciona palabra aleatoria de la categoría
    	$word = Word::with('answers', 'category')
        	->where('category_id', $request->category_id)
        	->inRandomOrder()
        	->first();

    	if (!$word) {
        	return response()->json(['message' => 'There are no words in this category'], 404);
    	}

    	return response()->json([
        	'category' => $word->category->name,
        	'word' => $word,
    	]);
    }
}
