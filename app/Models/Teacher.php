<?php
// app/Models/Teacher.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'firstname',
        'birthday',
        'sex',
        'phone',
        'second_phone',
        'email',
        'home_address',
        'npi',
        'identity_document'
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function teachings(): HasMany
    {
        return $this->hasMany(Teaching::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Obtenir les emplois du temps associés à ce professeur.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Obtenir l'utilisateur associé au professeur.
     */
    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    /**
     * Obtenir le nom complet du professeur.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }
}