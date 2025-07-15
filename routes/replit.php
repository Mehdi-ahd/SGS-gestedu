<?php
// Ce fichier est spécifique à l'environnement Replit pour faciliter le déploiement

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route du tableau de bord
Route::get('/dashboard', function () {
    return view('dashboard.admin');
})->name('dashboard');

// Routes des étudiants
Route::get('/students', function () {
    return view('students.index');
})->name('students.index');

// Routes pour tester d'autres fonctionnalités
Route::get('/test', function () {
    return "L'application fonctionne correctement!";
});