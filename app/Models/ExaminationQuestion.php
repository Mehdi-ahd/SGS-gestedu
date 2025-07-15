<?php
// app/Models/ExaminationQuestion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExaminationQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'examination_id'
    ];

    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ExaminationQuestionAnswer::class, 'question_id', 'id');
    }
}