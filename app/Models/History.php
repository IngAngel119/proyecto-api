<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_id',
        'event'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    // Eventos posibles
    const EVENT_DAILY_WORD_REQUESTED = 'daily_word_requested';
    const EVENT_ANSWER_SUBMITTED = 'answer_submitted';
    const EVENT_ANSWER_CORRECT = 'answer_correct';
    const EVENT_ANSWER_WRONG = 'answer_wrong';
    const EVENT_ALREADY_ANSWERED = 'already_answered';
    const EVENT_NO_WORDS_AVAILABLE = 'no_words_available';
}