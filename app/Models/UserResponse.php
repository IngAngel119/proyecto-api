<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserResponse extends Model
{
    protected $fillable = [
        'user_id',
        'word_id',
        'answer_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function word() {
        return $this->belongsTo(Word::class);
    }
    public function answer() {
        return $this->belongsTo(Answer::class);
    }     
}
