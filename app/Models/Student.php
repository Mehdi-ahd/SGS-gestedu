<?php
// app/Models/Student.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'firstname', 
        'birthday',
        'sex',
        'phone',
        'email',
        'home_address'
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function supervisors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'supervisor_student', 'student_id', 'supervisor_id') ->withPivot('link') ->withTimestamps();
    }

    public function isEnrolledIn($schoolYearId): bool
    {
        return $this->inscriptions()->where("school_year_id", $schoolYearId)->exists();
    }

    public function currentInscription($schoolYearId)
    {
        return $this->inscriptions()->where("school_year_id", $schoolYearId);
    }

    public function latestInscription()
    {
        return $this->inscriptions()->latest()->first();
    }

    //A revoir
    


    public function currentStudyLevels($schoolYearId): BelongsToMany
    {
        return $this->inscriptions()->where("school_year_id", $schoolYearId)->first();
    }

    public function examinationResults(): HasMany
    {
        return $this->hasMany(ExaminationResult::class);
    }

    public function attendanceList(): HasMany
    {
        return $this->hasMany(AttendanceList::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Obtenir le nom complet de l'étudiant.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Obtient le père de l'étudiant s'il existe.
     */
    public function getFather()
    {
        return $this->supervisors()->wherePivot('link', 'father')->first();
    }

    /**
     * Obtient la mère de l'étudiant si elle existe.
     */
    public function getMother()
    {
        return $this->supervisors()->wherePivot('link', 'mother')->first();
    }

    /**
     * Obtient les tuteurs de l'étudiant s'ils existent.
     */
    public function getTutors()
    {
        return $this->supervisors()->wherePivot('link', 'tutor')->get();
    }
    

    // Obtenir le groupe actuel d'un étudiant pour un niveau et une année donnés
    public function currentGroup($studyLevelId, $schoolYearId)
    {
        return $this->groupStudents()
                    ->where('study_level_id', $studyLevelId)
                    ->where('school_year_id', $schoolYearId)
                    ->first();
    }
}