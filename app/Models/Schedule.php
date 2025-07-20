<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'teaching_id',
        'week_day',
        'started_hour',
        'ended_hour'
    ];

    protected $casts = [
        'started_hour' => 'datetime:H:i',
        'ended_hour' => 'datetime:H:i',
    ];

    public function teaching(): BelongsTo
    {
        return $this->belongsTo(Teaching::class);
    }

    // Méthodes utilitaires
    public function getTimeSlot()
    {
        return $this->started_hour->format('H:i') . '-' . $this->ended_hour->format('H:i');
    }

    public function getDayName()
    {
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi'
        ];

        return $days[$this->week_day] ?? $this->week_day;
    }
}
