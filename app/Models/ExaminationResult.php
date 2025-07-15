<?php
// app/Models/ExaminationResult.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExaminationResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id',
        'examination_id',
        'score',
    ];

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(inscription::class);
    }

    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::class);
    }

    /**
     * Vérifier si l'étudiant a réussi l'examen.
     */
    public function hasPassed(): bool
    {
        return $this->marks_obtained >= $this->examination->passing_marks;
    }

    /**
     * Obtenir le pourcentage de réussite.
     */
    public function getPercentageAttribute(): float
    {
        if ($this->examination->total_marks === 0) {
            return 0;
        }
        
        return ($this->marks_obtained / $this->examination->total_marks) * 100;
    }
}