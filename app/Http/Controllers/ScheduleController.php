<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Teaching;
use App\Models\StudyLevel;
use App\Models\Group;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studyLevels = StudyLevel::orderBy('specification')->get();
        $schoolYears = SchoolYear::orderBy('id')->get();
        $currentYear = date('Y') . '-' . (date('Y') + 1);
        
        return view('schedules.index', compact('studyLevels', 'schoolYears', 'currentYear'));
    }

    /**
     * Get groups for a specific study level
     */
    public function getGroups(Request $request)
    {
        try {
            $studyLevelId = $request->query('study_level_id');
            
            if (!$studyLevelId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Study level ID is required'
                ]);
            }

            $studyLevel = StudyLevel::find($studyLevelId);
            
            if (!$studyLevel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Study level not found'
                ]);
            }

            $groups = $studyLevel->groups()->get();

            return response()->json([
                'success' => true,
                'groups' => $groups
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading groups: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Check if teaching exists for given criteria
     */
    public function checkTeaching(Request $request)
    {
        try {
            $request->validate([
                'study_level_id' => 'required|exists:study_levels,id',
                'group_id' => 'required|exists:groups,id',
                'school_year_id' => 'required'
            ]);

            $teaching = Teaching::with(['studyLevel', 'group', 'subject', 'teacher', 'schoolYear'])
                ->where('study_level_id', $request->study_level_id)
                ->where('group_id', $request->group_id)
                ->where('school_year_id', $request->school_year_id)
                ->first();

            if (!$teaching) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun enseignement trouvé pour ces critères. Veuillez d\'abord créer un enseignement.'
                ]);
            }

            return response()->json([
                'success' => true,
                'teaching' => $teaching
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get schedule data based on filters
     */
    public function getData(Request $request)
    {
        try {
            $query = Schedule::with(['teaching.studyLevel', 'teaching.group', 'teaching.subject', 'teaching.teacher', 'teaching.schoolYear']);

            // Apply filters
            if ($request->study_level_id) {
                $query->whereHas('teaching', function($q) use ($request) {
                    $q->where('study_level_id', $request->study_level_id);
                });
            }

            if ($request->group_id) {
                $query->whereHas('teaching', function($q) use ($request) {
                    $q->where('group_id', $request->group_id);
                });
            }

            if ($request->school_year_id) {
                $query->whereHas('teaching', function($q) use ($request) {
                    $q->where('school_year_id', $request->school_year_id);
                });
            }

            $schedules = $query->get();

            return response()->json([
                'success' => true,
                'schedules' => $schedules
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'teaching_id' => 'required|exists:teachings,id',
                'week_day' => 'required|array',
                'week_day.*' => 'required|string|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
                'started_hour' => 'required|array',
                'started_hour.*' => 'required|date_format:H:i',
                'ended_hour' => 'required|array',
                'ended_hour.*' => 'required|date_format:H:i|after:started_hour.*'
            ]);

            $teachingId = $request->teaching_id;
            $weekDays = $request->week_day;
            $startedHours = $request->started_hour;
            $endedHours = $request->ended_hour;

            // Check for conflicts
            foreach ($weekDays as $index => $weekDay) {
                $existingSchedule = Schedule::where('teaching_id', $teachingId)
                    ->where('week_day', $weekDay)
                    ->where(function($query) use ($startedHours, $endedHours, $index) {
                        $query->whereBetween('started_hour', [$startedHours[$index], $endedHours[$index]])
                              ->orWhereBetween('ended_hour', [$startedHours[$index], $endedHours[$index]])
                              ->orWhere(function($q) use ($startedHours, $endedHours, $index) {
                                  $q->where('started_hour', '<=', $startedHours[$index])
                                    ->where('ended_hour', '>=', $endedHours[$index]);
                              });
                    })
                    ->first();

                if ($existingSchedule) {
                    return response()->json([
                        'success' => false,
                        'message' => "Conflit détecté pour le {$weekDay} entre {$startedHours[$index]} et {$endedHours[$index]}"
                    ]);
                }
            }

            // Create schedules
            foreach ($weekDays as $index => $weekDay) {
                Schedule::create([
                    'teaching_id' => $teachingId,
                    'week_day' => $weekDay,
                    'started_hour' => $startedHours[$index],
                    'ended_hour' => $endedHours[$index]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Emploi du temps créé avec succès'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        try {
            $schedule->load(['teaching.studyLevel', 'teaching.group', 'teaching.subject', 'teaching.teacher', 'teaching.schoolYear']);

            return response()->json([
                'success' => true,
                'schedule' => $schedule
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        try {
            $schedule->load(['teaching.studyLevel', 'teaching.group', 'teaching.subject', 'teaching.teacher', 'teaching.schoolYear']);

            return response()->json([
                'success' => true,
                'schedule' => $schedule
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        try {
            $request->validate([
                'week_day' => 'required|string|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
                'started_hour' => 'required|date_format:H:i',
                'ended_hour' => 'required|date_format:H:i|after:started_hour'
            ]);

            // Check for conflicts (excluding current schedule)
            $existingSchedule = Schedule::where('teaching_id', $schedule->teaching_id)
                ->where('week_day', $request->week_day)
                ->where('id', '!=', $schedule->id)
                ->where(function($query) use ($request) {
                    $query->whereBetween('started_hour', [$request->started_hour, $request->ended_hour])
                          ->orWhereBetween('ended_hour', [$request->started_hour, $request->ended_hour])
                          ->orWhere(function($q) use ($request) {
                              $q->where('started_hour', '<=', $request->started_hour)
                                ->where('ended_hour', '>=', $request->ended_hour);
                          });
                })
                ->first();

            if ($existingSchedule) {
                return response()->json([
                    'success' => false,
                    'message' => "Conflit détecté pour le {$request->week_day} entre {$request->started_hour} et {$request->ended_hour}"
                ]);
            }

            $schedule->update([
                'week_day' => $request->week_day,
                'started_hour' => $request->started_hour,
                'ended_hour' => $request->ended_hour
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Emploi du temps mis à jour avec succès',
                'schedule' => $schedule->load(['teaching.studyLevel', 'teaching.group', 'teaching.subject', 'teaching.teacher'])
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();

            return response()->json([
                'success' => true,
                'message' => 'Emploi du temps supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }
}
