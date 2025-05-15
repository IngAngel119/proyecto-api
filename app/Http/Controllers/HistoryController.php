<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $histories = History::where('user_name', $user->name)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return response()->json($histories);
    }

    public function getUserActivity(Request $request)
    {
        $user = $request->user();
        
        $stats = [
            'total_questions_answered' => History::where('user_name', $user->name)
                ->whereIn('event', [
                    History::EVENT_ANSWER_CORRECT,
                    History::EVENT_ANSWER_WRONG
                ])->count(),
                
            'correct_answers' => History::where('user_name', $user->name)
                ->where('event', History::EVENT_ANSWER_CORRECT)
                ->count(),
                
            'wrong_answers' => History::where('user_name', $user->name)
                ->where('event', History::EVENT_ANSWER_WRONG)
                ->count(),
                
            'daily_words_requested' => History::where('user_name', $user->name)
                ->where('event', History::EVENT_DAILY_WORD_REQUESTED)
                ->count(),
        ];
        
        return response()->json($stats);
    }
}
