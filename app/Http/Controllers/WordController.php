<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\UserResponse;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WordController extends Controller
{
    public function dailyWord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
        ], [
            'category_id.exists' => ':input',
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
            // Registrar en el historial
            History::create([
                'user_id' => $userId,
                'event' => History::EVENT_ALREADY_ANSWERED,
                'word_id' => null // No hay palabra específica en este caso
            ]);
            
            return response()->json(['message' => 'You already answered in this category today'], 403);
        }

        // Selecciona palabra aleatoria de la categoría
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
            // Registrar en el historial
            History::create([
                'user_id' => $userId,
                'event' => History::EVENT_NO_WORDS_AVAILABLE,
                'word_id' => null
            ]);
            
            return response()->json(['message' => 'There are no words in this category'], 404);
        }

        // Registrar la solicitud de palabra diaria
        History::create([
            'user_id' => $userId,
            'word_id' => $word->id,
            'event' => History::EVENT_DAILY_WORD_REQUESTED
        ]);

        return response()->json([
            'category' => $word->category->name,
            'word' => $word,
        ]);
    }

    public function searchWords(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'order' => 'nullable|string|in:ASC,DESC',
            'limit' => 'nullable|integer|min:1|max:100',
        ], [
            'category_id.exists' => ':input', // Mensaje personalizado
            'order.in' => ':input', // Mensaje personalizado
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid search parameters.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $query = Word::query();

        // Filtro por texto (búsqueda que empiece con)
        if (!empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('definition', 'like', $searchTerm.'%');
        }

        // Filtro por categoría
        if (!empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        // Ordenación
        $direction = strtoupper($request->order ?? 'ASC');
        $query->orderBy('definition', $direction);

        // Limite de resultados
        $limit = $request->limit ?? 100;
        $query->limit($limit);

        $words = $query->get();

        return response()->json([
            'words' => $words,
            'count' => $words->count()
        ]);
    }

}
