<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        "name",
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "user_permission")->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, "role_permission")->withTimestamps();
    }
}
