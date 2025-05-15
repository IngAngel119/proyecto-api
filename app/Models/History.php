<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'word',
        'event'
    ];

    const EVENT_DAILY_WORD_REQUESTED = 'daily_word_requested';
    const EVENT_ANSWER_SUBMITTED = 'answer_submitted';
    const EVENT_ANSWER_CORRECT = 'answer_correct';
    const EVENT_ANSWER_WRONG = 'answer_wrong';
    const EVENT_ALREADY_ANSWERED = 'already_answered';
    const EVENT_NO_WORDS_AVAILABLE = 'no_words_available';
}
