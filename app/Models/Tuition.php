<?php
// app/Models/Tuition.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tuition extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_level_id',
        'year_session_id',
        'amount'
    ];

    public function studyLevel(): BelongsTo
    {
        return $this->belongsTo(StudyLevel::class);
    }

    public function yearSession(): BelongsTo
    {
        return $this->belongsTo(YearSession::class);
    }
}