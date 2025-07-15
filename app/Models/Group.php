<?php
// app/Models/Group.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id'
    ];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function studyLevels(): BelongsToMany
    {
        return $this->belongsToMany(StudyLevel::class, "group_study_level")->withPivot("classroom_id")->withTimestamps();
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'group_study_level', 'group_id', 'classroom_id')
                    ->withPivot('study_level_id')
                    ->withTimestamps();
    }

    // Un groupe a plusieurs étudiants
    

}