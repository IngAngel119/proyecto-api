<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\UserResponse;
use Illuminate\Support\Facades\Validator;

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

    	// Selecciona palabra aleatoria de la categoría que no haya sido contestada por el usuario
        $word = Word::with('answers', 'category')
        ->where('category_id', $request->category_id)
        ->whereNotIn('id', function($query) {
            $query->select('word_id')
                ->from('user_responses')
                ->where('user_id', auth()->id());
        })
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

    public function searchWords(Request $request)
    {
        $query = Word::query();
        
        // Filtro por texto (búsqueda que empiece con)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'like', $searchTerm.'%');
        }
        
        // Filtro por categoría
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
        
        // Ordenación
        if ($request->has('order') && !empty($request->order)) {
            $direction = strtoupper($request->order) == 'DESC' ? 'DESC' : 'ASC';
            $query->orderBy('name', $direction);
        } else {
            // Orden por defecto si no se especifica
            $query->orderBy('name', 'ASC');
        }
        
        // Limite de resultados
        if ($request->has('limit') && !empty($request->limit)) {
            $limit = max(1, (int)$request->limit); // Asegurar que sea al menos 1
            $query->limit($limit);
        }
        
        $words = $query->get();
        
        return response()->json([
            'words' => $words,
            'count' => $words->count()
        ]);
    }
}
