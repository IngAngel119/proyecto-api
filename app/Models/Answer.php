<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Answer extends Model
{
    protected $fillable = ['word_id', 'text', 'is_correct'];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
