<?php
// app/Models/YearSession.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class YearSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'denomination'
    ];

    public function tuitions(): HasMany
    {
        return $this->hasMany(Tuition::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}