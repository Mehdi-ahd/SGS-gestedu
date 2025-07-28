<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudyLevelController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeachingController;
use App\Http\Controllers\TuitionController;
use App\Http\Controllers\UserController;
use App\Models\Classroom;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\ParentPaymentController;

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

Route::get('/frais-scolaires', function () {
    return view('tuitions');
})->name('tuitions');

Route::get("/rol", function() {
    $roles = [
        "admin" => "Administrateur",
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
    echo "Roles crés avec succès";
});

// Routes d'authentification - accessibles sans être connecté
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::get('/register/{token}', [AuthController::class, 'showRegisterForm'])->name('register.with.token');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/register/{token}', [AuthController::class, 'register'])->name('register.with.token.post');
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
        // Route de vérification accessible à tous les parents
        Route::get('/verification', [ParentController::class, 'parentVerification'])->name('verification');

        // Autres routes avec middleware de vérification d'identité
        Route::middleware('parent.identity.verification')->group(function () {
            Route::get('/', [DashboardController::class, 'parent'])->name('dashboard');
            Route::get('/profile', [ParentController::class, 'parentProfile'])->name('profile');
            Route::put('/profile', [ParentController::class, 'updateProfile'])->name('profile.update');
            Route::get('/children/{id}', [ParentController::class, 'showChildren'])->name('showChildren');
            Route::get('/student/{id}', [ParentController::class, 'showStudentProfile'])->name('child.details');
            Route::get('/student-registration', [StudentController::class, 'studentRegistration'])->name('student-registration');
            Route::post('/student-registration-process', [StudentController::class, 'studentRegistrationProcess'])->name('studentRegistrationProcess');
            Route::get('/student/{id}/{year_id}', [StudentController::class, 'academicDetails'])->name('child.academic-year-details');
            Route::get('/payment-form', [PaymentController::class, 'showPaymentForm'])->name('payment.form');

            // API pour récupérer les élèves d'un parent
            Route::get('/api/students/{parentId}', [PaymentController::class, 'getStudentsForPayment'])->name('api.students');

            // Traitement du paiement
            Route::post('/payment', [PaymentController::class, 'storePayment'])->name('payment.store');
        });
    });

    // Routes spécifiques au dashboard professeur
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/', [DashboardController::class, 'teacher'])->name('dashboard');
        Route::get('/profile', [TeacherController::class, 'profile'])->name('profile');
    });

    // Routes d'administration pour les tokens d'invitation
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/invitation-tokens', [AuthController::class, 'showInvitationTokens'])->name('invitation-tokens');
        Route::post('/generate-invitation-token', [AuthController::class, 'generateInvitationToken'])->name('generate-invitation-token');
    });

    //Route::get("/verification/{id}", [UserController::class, "showVerificationForm"])->name("showVerificationForm");
    Route::post('/verification', [UserController::class, 'storeVerification'])->name('storeVerification');
    Route::get("/account-confirmation", [UserController::class, "accountConfirmationIndex"])->name("accountConfirmationIndex");
    Route::get("/account-confirmation/{id}", [UserController::class, "accountConfirmationShow"])->name("accountConfirmationShow");
    Route::post("/account-confirmation/validate", [UserController::class, "validateAccount"])->name("validateAccount");
    Route::post("/account-confirmation/reject", [UserController::class, "rejectAccount"])->name("rejectAccount");


    Route::prefix('school-structure/')->name("school-structure.")->group(function() {
        //Gestion des matieres
        Route::resource("subjects", SubjectController::class)->names("subjects");
        // Route pour récupérer les niveaux d'une matière
        Route::get('subjects/{subject}/levels', [SubjectController::class, 'getSubjectLevels'])->name('subjects.levels');
        // Route pour supprimer un niveau d'une matière
        Route::delete('subjects/{subject}/levels/{level}', [SubjectController::class, 'removeSubjectLevel'])->name('subjects.remove-level');
        // Route pour mettre à jour le coefficient
        Route::put('subjects/{subject}/levels/{level}/coefficient', [SubjectController::class, 'updateLevelCoefficient'])->name('subjects.update-coefficient');

        //Gestions des niveaux d'etudes
        Route::resource("study-level", StudyLevelController::class)->names("study-level");

        // Route pour récupérer les groupes d'un niveau d'étude
        Route::get('school-structure/classrooms/groups', [ClassroomController::class, 'getGroups'])->name('classrooms.groups');
        //Gestion des salles de classes
        Route::resource("classrooms", ClassroomController::class)->names("classrooms");
        // Routes pour l'assignation des groupes aux salles
        Route::post('classrooms/{classroom}/assign', [ClassroomController::class, 'assignGroup'])->name('classrooms.assign');
        Route::post('classrooms/{classroom}/unassign', [ClassroomController::class, 'unassignGroup'])->name('classrooms.unassign');

        //Routes pour la gestion des frais de scolarité et autres frais
        Route::resource('tuitions', TuitionController::class)->names('tuitions');

        // Route pour récupérer les groupes d'un niveau d'étude pour les enseignements
        Route::get('teachings/groups', [TeachingController::class, 'getGroups'])->name('teachings.groups');
        Route::resource('/teachings', TeachingController::class)->names('teachings');

        Route::get('schedules/groups', [ScheduleController::class, 'getGroups'])->name('schedules.groups');
        Route::get('schedules/data', [ScheduleController::class, 'getData'])->name('schedules.getData');
        Route::post('schedules/check-teaching', [ScheduleController::class, 'checkTeaching']);
        // Routes pour les emplois du temps
        Route::resource('schedules', ScheduleController::class)->names('schedules');
    });


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
    // Route::get('/schedules', function() {
    //     return view("schedules.index");
    // })->name('schedules.index');
    //Route::post('schedules', [ScheduleController::class, 'store']);

    // Gestion des examens
    Route::get('/examinations', function() {
        return view('examinations.index');
    })->name('examinations.index');

    Route::get('/examinations/create', function() {
        return view('examinations.create');
    })->name('examinations.create');

    // Gestion des paiements - principalement pour les comptables et admins
    Route::resource('/payments', PaymentController::class);

    // Routes API pour les paiements
    Route::get('/api/payments', [PaymentController::class, 'getPayments'])->name('api.payments');
    Route::get('/api/study-levels', [PaymentController::class, 'getStudyLevels'])->name('api.study-levels');
    Route::get('/api/year-sessions', [PaymentController::class, 'getYearSessions'])->name('api.year-sessions');

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
    // Route::post("/users/{id}/validate", [UserController::class, "validateAccount"])->name("users.validate");
    // Route::post("/users/{id}/reject", [UserController::class, "rejectAccount"])->name("users.reject");
    Route::get('roles/edit/{id}', [RoleController::class, "editPermission"])->name("roles.editPermission");
    Route::post("/roles/updatePermission", [RoleController::class, "UpdatePermissions"])->name("roles.updatePermission");

    // Routes pour les paiements - Administrateur
    Route::prefix('admin/payments')->name('admin.payments.')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/create', [PaymentController::class, 'create'])->name('create');
        Route::get('/data', [PaymentController::class, 'getPayments'])->name('data');
        Route::post('/search-student', [PaymentController::class, 'searchStudent'])->name('search-student');
        Route::get('/available-fees', [PaymentController::class, 'getAvailableFees'])->name('available-fees');
        Route::post('/store', [PaymentController::class, 'store'])->name('store');
    });

    // Routes pour les paiements - Parent
    Route::prefix('parent/payments')->name('parent.payments.')->middleware(['auth','parent.identity.verification'])->group(function () {
        Route::get('/', [ParentPaymentController::class, 'index'])->name('index');
        Route::get('/history', [ParentPaymentController::class, 'history'])->name('history');
        Route::get('/child-fees/{enrollment}', [ParentPaymentController::class, 'getChildFees'])->name('child-fees');
        Route::post('/initialize', [ParentPaymentController::class, 'initializePayment'])->name('initialize');
        Route::post('/callback', [ParentPaymentController::class, 'paymentCallback'])->name('callback');
    });
});