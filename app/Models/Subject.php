<?php
// app/Models/Subject.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function studyLevels(): BelongsToMany
    {
        return $this->belongsToMany(StudyLevel::class, 'study_level_subject') ->withPivot('coefficient') ->withTimestamps();
    }

    public function teachings(): HasMany
    {
        return $this->hasMany(Teaching::class);
    }

    public function subjectsNumber() 
    {
        return $this->count();
    }
}