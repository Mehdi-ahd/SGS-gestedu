<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        "id",
        "name",
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, "role_permission")->withTimestamps();
    }

    public function invitationToken(): HasMany
    {
        return $this->hasMany(InvitationToken::class);
    }
}
