<?php
// app/Models/ExaminationQuestionAnswer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExaminationQuestionAnswer extends Model
{
    protected $fillable = [
        'examination_id',
        'question_id',
        'answer_text',
        'is_right'
    ];
    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::class);
    }
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}