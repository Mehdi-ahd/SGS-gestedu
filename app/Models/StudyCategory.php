<?php
// app/Models/StudyCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function studyLevels(): HasMany
    {
        return $this->hasMany(StudyLevel::class);
    }
}