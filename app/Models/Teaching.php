<?php
// app/Models/Teaching.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teaching extends Model
{
    use HasFactory;

    protected $table = 'teaching';

    protected $fillable = [
        'study_level_id',
        'subject_id',
        'school_year_id',
        'teacher_id'
    ];

    // protected $keyType = 'string';
    // public $incrementing = false;


    public function studyLevel(): BelongsTo
    {
        return $this->belongsTo(StudyLevel::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function attendance(): BelongsToMany
    {
        return $this->belongsToMany(Inscription::class, "attendance_list")->withPivot(["day", "observation"])->withTimestamps();
    }
}