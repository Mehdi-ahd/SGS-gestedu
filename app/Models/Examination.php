<?php
// app/Models/Examination.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        "teaching_id",
        "year_session_id",
        'duration',
        'file_path',
        'type',
    ];

    public function teaching(): BelongsTo
    {
        return $this->belongsTo(Teaching::class);
    }

    /**
     * Obtenir la session d'année associée à cet examen.
     */
    public function yearSession(): BelongsTo
    {
        return $this->belongsTo(YearSession::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ExaminationQuestion::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(ExaminationResult::class);
    }

    public function examination_results(): BelongsToMany
    {
        return $this->belongsToMany(Inscription::class, "examination_results")->withPivot("score")->withTimestamps();
    }

    
}