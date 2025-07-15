<?php
// app/Models/AttendanceList.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceList extends Model
{
    use HasFactory;

    protected $table = 'attendance_list';

    protected $fillable = [
        "inscription_id",
        "teaching_id",
        'day',
        'observation',
    ];

    protected $casts = [
        'day' => 'date',
    ];

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function teaching(): BelongsTo
    {
        return $this->belongsTo(Teaching::class);
    }

    /**
     * Obtenir le créneau horaire associé à cette présence.
     */
    public function schedule()
    {
        return Schedule::where('study_level', $this->study_level)
            ->where('day', $this->day)
            ->where('start_hour', $this->start_hour)
            ->first();
    }
}