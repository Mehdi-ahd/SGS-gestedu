# Guide d'installation finale pour GestEdu

## Fichiers et structure à télécharger

Pour installer GestEdu dans votre environnement local WampServer, vous devez télécharger les fichiers suivants:

### 1. Fichiers de migration (dossier database/migrations)
- `2023_01_01_000001_create_students_table.php`
- `2023_01_01_000002_create_supervisors_table.php`
- `2023_01_01_000003_create_supervisor_student_table.php`
- `2023_01_01_000004_create_schools_table.php`
- `2023_01_01_000005_create_teachers_table.php`
- `2023_01_01_000006_create_accountants_table.php`
- `2023_01_01_000007_create_study_categories_table.php`
- `2023_01_01_000008_create_study_levels_table.php`
- `2023_01_01_000009_create_classrooms_table.php`
- `2023_01_01_000010_create_subjects_table.php`
- `2023_01_01_000011_create_study_level_subject_table.php`
- `2023_01_01_000012_create_school_years_table.php`
- `2023_01_01_000013_create_teaching_table.php`
- `2023_01_01_000014_create_schedules_table.php`
- `2023_01_01_000015_create_year_sessions_table.php`
- `2023_01_01_000016_create_examinations_table.php`
- `2023_01_01_000017_create_examination_results_table.php`
- `2023_01_01_000018_create_attendance_table.php`
- `2023_01_01_000019_create_messages_table.php`
- `2023_01_01_000020_create_fee_types_table.php`
- `2023_01_01_000021_create_fee_structure_table.php`
- `2023_01_01_000022_create_payments_table.php`
- `2023_01_01_000023_create_users_table.php`
- `2023_01_01_000024_create_documents_table.php`

### 2. Fichiers de vues (dossier resources/views)
- `layouts/app.blade.php` - Template principal avec menu latéral
- `layouts/auth.blade.php` - Template pour authentification
- `auth/login.blade.php` - Page de connexion
- `welcome.blade.php` - Page d'accueil
- `register.blade.php` - Page d'inscription
- `dashboard/admin.blade.php` - Tableau de bord administrateur
- `students/index.blade.php` - Liste des étudiants

## Instructions d'installation

### Étape 1: Création d'un projet Laravel sous WampServer
```bash
# Naviguez vers le dossier www de WampServer
cd C:\wamp64\www

# Créez un nouveau projet Laravel
composer create-project laravel/laravel:^11.0 gestedu
cd gestedu
```

### Étape 2: Configuration de la base de données
1. Créez une base de données MySQL nommée `gestedu_app` via phpMyAdmin
2. Modifiez le fichier `.env` pour configurer la connexion à la base de données:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestedu_app
DB_USERNAME=root
DB_PASSWORD=
```

### Étape 3: Importation des fichiers
1. Créez les dossiers nécessaires si ils n'existent pas:
```bash
mkdir -p resources/views/layouts
mkdir -p resources/views/auth
mkdir -p resources/views/dashboard
mkdir -p resources/views/students
```

2. Copiez les fichiers de migration dans le dossier `database/migrations/`
3. Copiez les fichiers de vues dans leurs dossiers respectifs sous `resources/views/`

### Étape 4: Configuration des routes
Modifiez le fichier `routes/web.php` pour ajouter les routes correctes:

```php
<?php

use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

// Tableau de bord
Route::get('/dashboard', function () {
    return view('dashboard.admin');
})->name('dashboard');

// Routes des étudiants
Route::prefix('students')->group(function () {
    Route::get('/', function () {
        return view('students.index');
    })->name('students.index');
    
    Route::get('/create', function () {
        return redirect()->route('students.index');
    })->name('students.create');
    
    Route::get('/{id}', function ($id) {
        return redirect()->route('students.index');
    })->name('students.show');
    
    Route::get('/{id}/edit', function ($id) {
        return redirect()->route('students.index');
    })->name('students.edit');
});

// Routes des enseignants
Route::prefix('teachers')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('teachers.index');
});

// Routes des parents
Route::prefix('parents')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('parents.index');
});

// Autres routes nécessaires
Route::get('/attendance/create', function () {
    return redirect()->route('dashboard');
})->name('attendance.create');

Route::get('/schedules', function () {
    return redirect()->route('dashboard');
})->name('schedules.index');

Route::get('/examinations/create', function () {
    return redirect()->route('dashboard');
})->name('examinations.create');

Route::get('/payments', function () {
    return redirect()->route('dashboard');
})->name('payments.index');
```

### Étape 5: Exécution des migrations
```bash
php artisan migrate
```

### Étape 6: Démarrage de l'application
1. Via l'URL WampServer:
   http://localhost/gestedu/public/

2. Ou via le serveur de développement Laravel:
```bash
php artisan serve
```
   Puis visitez http://localhost:8000

## Problèmes courants et solutions

### Erreur 404 - Page non trouvée
1. Assurez-vous que le module `mod_rewrite` est activé dans Apache
2. Vérifiez que le fichier `.htaccess` est présent dans le dossier `public`
3. Dans votre fichier de configuration Apache, assurez-vous que `AllowOverride All` est défini

### Erreur de connexion à la base de données
1. Vérifiez les informations de connexion dans le fichier `.env`
2. Assurez-vous que la base de données `gestedu_app` existe
3. Vérifiez que l'utilisateur MySQL a les permissions nécessaires

### Les styles CSS ne s'appliquent pas
1. Vérifiez que vous accédez au site via l'URL complète incluant `/public`
2. Vérifiez que les CDN pour Bootstrap et Font Awesome sont accessibles

### Routes non trouvées
1. Exécutez `php artisan route:clear` pour effacer le cache des routes
2. Exécutez `php artisan route:list` pour vérifier que toutes les routes sont bien définies

## Configuration d'un hôte virtuel (pour une meilleure expérience)

Pour éviter d'utiliser `/public` dans l'URL:

1. Modifiez le fichier `httpd-vhosts.conf` d'Apache:
```apache
<VirtualHost *:80>
    ServerName gestedu.local
    DocumentRoot "C:/wamp64/www/gestedu/public"
    <Directory "C:/wamp64/www/gestedu/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

2. Ajoutez à votre fichier hosts:
```
127.0.0.1 gestedu.local
```

3. Redémarrez WampServer

4. Accédez à http://gestedu.local