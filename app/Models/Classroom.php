<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity'
    ];

    
    public function study_level_group(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_study_level', 'classroom_id', 'group_id') ->withPivot('study_level_id') ->withTimestamps();
    }

    /**
     * Relation alternative pour obtenir les groupes via les niveaux d'étude
     */
    public function study_level()
    {
        return $this->belongsToMany(Group::class, 'group_study_level', 'classroom_id', 'study_level_id') ->withPivot('classroom_id') ->withTimestamps();
    }
}
