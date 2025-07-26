<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationToken extends Model
{
    protected $fillable = [
        'token',
        'role_id',
        'validity_period',
    ];

    protected $casts = [
        'validity_period' => 'datetime'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isValid(): bool
    {
        return now()->lessThan($this->validity_period);
    }
}
