<?php
// app/Models/Bill.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        "inscription_id",
        "tuition_id",
        'amount_paid',
        'payment_step',
        'paid_by',
        "paid_with",
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function tuitions(): BelongsTo
    {
        return $this->belongsTo(Tuition::class);
    }
}