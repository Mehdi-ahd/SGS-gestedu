<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudyLevelController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Models\Classroom;
use App\Models\Role;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page d'accueil - accessible à tous
Route::get('/', function () {
    return view('welcome');
})->name("index");

Route::get("/rol", function() {
    $roles = [
        "teacher"=>"Professeur",
        "supervisor" => "Parent",
        "accountant" => "Caissier(e)"
    ];
    foreach ($roles as $role_id=>$role_name) {
        Role::create([
            "id" => $role_id,
            "name" => $role_name,
        ]);
    } ;
});

// Routes d'authentification - accessibles sans être connecté
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Route de déconnexion - nécessite d'être connecté
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// TOUTES LES ROUTES PROTÉGÉES - nécessitent une authentification
Route::middleware('auth')->group(function () {
    // Tableau de bord principal (redirection selon le rôle)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tableaux de bord spécifiques aux rôles
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/teacher', [DashboardController::class, 'teacher'])->name('dashboard.teacher');
    Route::get('/dashboard/student', [DashboardController::class, 'student'])->name('dashboard.student');
    Route::get('/dashboard/parent', [DashboardController::class, 'parent'])->name('dashboard.parent');
    Route::get('/dashboard/accountant', [DashboardController::class, 'accountant'])->name('dashboard.accountant');

    // Routes spécifiques au dashboard parent
    Route::prefix('parent')->name('parent.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'parent'])->name('dashboard');
        Route::get('/profile', [ParentController::class, 'parentProfile'])->name('profile');
        Route::put('/profile', [ParentController::class, 'updateProfile'])->name('profile.update');
        Route::get('/verification', [ParentController::class, 'parentVerification'])->name('verification');
        Route::get('/children/{id}', [ParentController::class, 'showChildren'])->name('showChildren');
        Route::get('/student/{id}', [ParentController::class, 'showStudentProfile'])->name('student.profile');
        Route::get('/student-registration', [StudentController::class, 'studentRegistration'])->name('student-registration');
    });

    Route::get("/verification/{id}", [UserController::class, "showVerificationForm"])->name("showVerificationForm");
    Route::post('/verification', [UserController::class, 'storeVerification'])->name('storeVerification');
    Route::get("/account-confirmation", [UserController::class, "accountConfirmationIndex"])->name("accountConfirmationIndex");
    Route::get("/account-confirmation/{id}", [UserController::class, "accountConfirmationShow"])->name("accountConfirmationShow");



    //Gestion des matieres
    Route::resource("school-structure/subjects", SubjectController::class)->names("school-structure.subjects");
    // Route pour récupérer les niveaux d'une matière
    Route::get('school-structure/subjects/{subject}/levels', [SubjectController::class, 'getSubjectLevels'])->name('school-structure.subjects.levels');
    // Route pour supprimer un niveau d'une matière
    Route::delete('school-structure/subjects/{subject}/levels/{level}', [SubjectController::class, 'removeSubjectLevel'])->name('school-structure.subjects.remove-level');
    // Route pour mettre à jour le coefficient
    Route::put('school-structure/subjects/{subject}/levels/{level}/coefficient', [SubjectController::class, 'updateLevelCoefficient'])->name('school-structure.subjects.update-coefficient');

    //Gestions des niveaux d'etudes
    Route::resource("school-structure/study-level", StudyLevelController::class)->names("school-structure.study-level");

    // Route pour récupérer les groupes d'un niveau d'étude (doit être avant la route resource)
    Route::get('school-structure/classrooms/groups', [ClassroomController::class, 'getGroups'])->name('school-structure.classrooms.groups');
    //Gestion des salles de classes
    Route::resource("school-structure/classrooms", ClassroomController::class)->names("school-structure.classrooms");
    // Routes pour l'assignation des groupes aux salles
    Route::post('school-structure/classrooms/{classroom}/assign', [ClassroomController::class, 'assignGroup'])->name('school-structure.classrooms.assign');
    Route::post('school-structure/classrooms/{classroom}/unassign', [ClassroomController::class, 'unassignGroup'])->name('school-structure.classrooms.unassign');

    // Gestion des enseignants
    Route::resource('teachers', TeacherController::class);
    // Route::get("teachers/verification/{id}", [ParentController::class, "showiden"])->name("showiden");

    // Gestion des parents - utilisation du ParentController au lieu des fonctions anonymes
    Route::resource('parents', ParentController::class);
    //Route::get("parent/{id}/children", [ParentController::class, "showChildren"])->name("showChildren");
    // Route::get("parents/verif", [ParentController::class, "showiden"])->name("showiden");

    // Gestion des étudiants - CRUD complet avec StudentController
    Route::resource('students', StudentController::class);

    // Routes pour la réinscription des anciens élèves
    Route::get('/students/reenrollment/index', [StudentController::class, 'reenrollment'])->name('students.reenrollment');
    Route::post('/students/reenrollment/{id}', [StudentController::class, 'processReenrollment'])->name('students.processReenrollment');
    Route::get("/students/createa/ig", [StudentController::class, "inde"]);

    // Gestion des présences
    Route::get('/attendance/create', [TeacherController::class, "attendanceList"])->name('attendance.create');

    Route::post('/attendance', function() {
        return redirect()->back()->with('success', 'Présences enregistrées avec succès');
    })->name('attendance.store');

    // Emploi du temps
    Route::get('/schedules', function() {
        return view("schedules.index");
    })->name('schedules.index');

    // Gestion des examens
    Route::get('/examinations', function() {
        return view('examinations.index');
    })->name('examinations.index');

    Route::get('/examinations/create', function() {
        return view('examinations.create');
    })->name('examinations.create');

    // Gestion des paiements - principalement pour les comptables et admins
    Route::get('/payments', function() {
        return view('payments.index');
    })->name('payments.index');

    Route::get('/payments/create', function() {
        return view('payments.create');
    })->name('payments.create');

    // Gestion des bulletins
    Route::get('/reports', function() {
        return view('reports.index');
    })->name('reports.index');

    // Gestion des messages
    Route::get('/messages', function() {
        return view('messages.index');
    })->name('messages.index');

    // Paramètres utilisateur
    Route::get('/settings', function() {
        return view('settings.index');
    })->name('settings.index');

    Route::resource("users", UserController::class);
    Route::resource("roles", RoleController::class);
    Route::get('users/edit/{id}', [UserController::class, "editPermission"])->name("users.editPermission");
    Route::post("/users/updatePermission", [UserController::class, "UpdatePermissions"])->name("users.updatePermission");
    Route::get('roles/edit/{id}', [RoleController::class, "editPermission"])->name("roles.editPermission");
    Route::post("/roles/updatePermission", [RoleController::class, "UpdatePermissions"])->name("roles.updatePermission");
});