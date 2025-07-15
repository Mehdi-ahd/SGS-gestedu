<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Inscription extends Model
{
    protected $fillable = [
        "student_id",
        "group_id",
        "study_level_id",
        "school_year_id",
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function study_level(): BelongsTo
    {
        return $this->belongsTo(StudyLevel::class);
    }

    public function school_year(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function attendance(): BelongsToMany
    {
        return $this->belongsToMany(Teaching::class, "attendance_list")->withPivot(["day", "observation"])->withTimestamps();
    }

    public function examination_results (): BelongsToMany
    {
        return $this->belongsToMany(Examination::class, "examination_results")->withPivot("score")->withTimestamps();
    }
}
