<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'lastname',
        'firstname',
        'birthday',
        'sex',
        'phone',
        'second_phone',
        'email',
        'password',
        'home_address',
        'job',
        'work_address',
        'profile_picture',
        'role_id',
        "status"
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthday' => 'date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */


    public function role() 
    {
        return $this->belongsTo(Role::class, "role_id");
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'supervisor_student', 'supervisor_id', 'student_id') ->withPivot('link') ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getFullName()
    {
        return "$this->lastname $this->firstname";
    }

    public function getBirthday()
    {
        return $this->birthday->format("d/m/Y");
    }

    public function getSex()
    {
        if( $this->sex === "M") {
            return "Masculin";
        } else {
            return "Féminin";
        }
    }

    public function teachings(): HasMany
    {
        return $this->hasMany(Teaching::class, "teacher_id", 'id');
    }
 

    // public function __call($method, $parameters)
    // {
    //     $roleName = Str::snake($method);
    //     $role = Role::where("name", $roleName)->first();
    //     if($role) {
    //         $modelClass = 'App\\Models\\' . Str::studly($roleName);
    //         if(class_exists($modelClass)) {
    //             return $this->hasOne($modelClass, 'email', 'email');
    //         }
    //     }

    //     return parent::__call($method, $parameters);
    // }

    /*
    public function __call($method, $parameters)
    {
        $roleName = Str::studly($method) ;
        if(array_key_exists($roleName, $this->roleModelMap)) {
            $modelClass = $this->roleModelMap[$roleName];
            return $this->hasOne($modelClass, 'email', 'email');
        }
        return parent::__call($method, $parameters);
    }

    public function personalData() {
        if(!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return match ($this->role->name ?? null) {
            "Parent" => $this->supervisor,
            "teacher" => $this->teacher,
            "Administrateur" => $this->administrator,
        };
    }
    */

    public function specificPermissions() 
    {
        return $this->belongsToMany(Permission::class, "user_permission")->withPivot("status")->withTimestamps();
    }

    public function rolePermissions()
    {
        return $this->role->permissions;
    }

    public function get_date()
    {
        return $this->created_at->format("d/m/Y à H:i");
    }

    
    /**
     * Vérifier si l'utilisateur est un administrateur.
     */
    public function isAdmin(): bool
    {
        return $this->role->id === "admin";
    }

    /**
     * Vérifier si l'utilisateur est un enseignant.
     */
    public function isTeacher(): bool
    {
        return $this->role->id === 'teacher';
    }

    /**
     * Vérifier si l'utilisateur est un étudiant.
     */
    public function isStudent(): bool
    {
        return $this->role->id === 'student';
    }

    /**
     * Vérifier si l'utilisateur est un parent.
     */
    public function isParent(): bool
    {
        return $this->role->id === 'supervisor';
    }

    
    /**
     * Vérifier si l'utilisateur est un comptable.
     */
    public function isAccountant(): bool
    {
        return $this->role === 'accountant';
    }

    public function documents(): HasMany
    {
        return $this->hasMany(UserDocument::class);
    }

}