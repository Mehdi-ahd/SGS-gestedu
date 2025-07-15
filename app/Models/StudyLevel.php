<?php
// app/Models/StudyLevel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudyLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_category_id',
        'specification'
    ];

    public function studyCategory(): BelongsTo
    {
        return $this->belongsTo(StudyCategory::class);
    }

    public function tuitions(): HasMany
    {
        return $this->hasMany(Tuition::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function teachings(): HasMany
    {
        return $this->hasMany(Teaching::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'study_level_subject')->withPivot('coefficient')->withTimestamps();
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, "group_study_level")->withPivot("classroom_id")->withTimestamps();
    }

    public function repartitions(): HasMany
    {
        return $this->hasMany(Repartition::class);
    }
    
}