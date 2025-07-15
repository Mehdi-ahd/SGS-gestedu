<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repartition extends Model
{
    protected $fillable = [
        "group_id",
        "study_level_id",
        "classroom_id"
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function studyLevel(): BelongsTo
    {
        return $this->belongsTo(StudyLevel::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
