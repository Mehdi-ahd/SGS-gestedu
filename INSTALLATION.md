# Guide d'installation de GestEdu

Ce guide vous aidera à installer et configurer l'application GestEdu sur votre environnement local WampServer.

## Prérequis

- WampServer installé et fonctionnel (Apache, MySQL, PHP)
- Composer installé
- Git (optionnel)
- PHP 8.1 ou supérieur
- MySQL 5.7 ou supérieur

## Étapes d'installation

### 1. Création du projet Laravel

1. Ouvrez votre terminal (cmd) et naviguez vers le dossier www de WampServer (généralement `C:\wamp64\www\`).
2. Créez un nouveau projet Laravel:

```bash
composer create-project laravel/laravel:^11.0 gestedu
cd gestedu
```

### 2. Configuration de la base de données

1. Ouvrez phpMyAdmin via WampServer (généralement http://localhost/phpmyadmin)
2. Créez une nouvelle base de données nommée `gestedu_app`
3. Modifiez le fichier `.env` dans la racine du projet:

```
APP_NAME=GestEdu
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestedu_app
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Copie des fichiers

Importez les fichiers suivants dans votre projet Laravel:

#### Fichiers de migration (dans /database/migrations/)
Tous les fichiers de migration pour créer la structure de la base de données, notamment:
- `2023_01_01_000001_create_students_table.php`
- `2023_01_01_000002_create_supervisors_table.php`
- Et tous les autres fichiers de migration (24 au total)

#### Fichiers de vues (dans /resources/views/)
- `/layouts/app.blade.php`
- `/layouts/auth.blade.php`
- `/auth/login.blade.php`
- `/dashboard/admin.blade.php`
- `/students/index.blade.php`
- `/welcome.blade.php`

### 4. Configuration des routes

Remplacez le contenu du fichier `routes/web.php` par:

```php
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
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
        return view('students.create');
    })->name('students.create');
    
    Route::get('/{id}', function ($id) {
        return view('students.show');
    })->name('students.show');
    
    Route::get('/{id}/edit', function ($id) {
        return view('students.edit');
    })->name('students.edit');
    
    Route::post('/', function () {
        return redirect()->route('students.index');
    })->name('students.store');
    
    Route::put('/{id}', function ($id) {
        return redirect()->route('students.index');
    })->name('students.update');
    
    Route::delete('/{id}', function ($id) {
        return redirect()->route('students.index');
    })->name('students.destroy');
});

// Routes des enseignants
Route::prefix('teachers')->group(function () {
    Route::get('/', function () {
        return view('teachers.index');
    })->name('teachers.index');
    
    // Autres routes pour les enseignants...
});

// Routes des parents
Route::prefix('parents')->group(function () {
    Route::get('/', function () {
        return view('parents.index');
    })->name('parents.index');
    
    // Autres routes pour les parents...
});

// Autres modules
Route::get('/attendance/create', function () {
    return view('attendance.create');
})->name('attendance.create');

Route::get('/schedules', function () {
    return view('schedules.index');
})->name('schedules.index');

Route::get('/examinations/create', function () {
    return view('examinations.create');
})->name('examinations.create');

Route::get('/payments', function () {
    return view('payments.index');
})->name('payments.index');
```

### 5. Exécution des migrations

Après avoir copié tous les fichiers de migration, exécutez:

```bash
php artisan migrate
```

### 6. Démarrage du serveur

1. Si vous utilisez WampServer, vous pouvez accéder directement à votre application via:
   http://localhost/gestedu/public/

2. Alternativement, vous pouvez utiliser le serveur de développement Laravel:
```bash
php artisan serve
```
Puis accéder à http://localhost:8000

### 7. Configuration d'un hôte virtuel (optionnel mais recommandé)

Pour éviter d'avoir à utiliser `/public` dans l'URL, vous pouvez configurer un hôte virtuel:

1. Modifiez le fichier `httpd-vhosts.conf` de Apache (généralement dans `C:\wamp64\bin\apache\apache2.4.x\conf\extra\`)
2. Ajoutez:
```
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
3. Modifiez votre fichier hosts (généralement `C:\Windows\System32\drivers\etc\hosts`) et ajoutez:
```
127.0.0.1 gestedu.local
```
4. Redémarrez WampServer
5. Accédez à http://gestedu.local

## Résolution des problèmes

### Erreur 404 - Page non trouvée
- Vérifiez que mod_rewrite est activé dans Apache
- Assurez-vous que le fichier `.htaccess` est présent dans le dossier public
- Vérifiez que AllowOverride est bien défini sur All dans la configuration Apache

### Problèmes de base de données
- Assurez-vous que les informations de connexion dans `.env` sont correctes
- Vérifiez que la base de données `gestedu_app` existe
- Vérifiez les privilèges de l'utilisateur MySQL

### Autres problèmes courants
- Exécutez `composer dump-autoload` pour actualiser l'autoloader
- Nettoyez le cache avec `php artisan cache:clear`
- Vérifiez les logs dans `storage/logs/laravel.log`

## Structure du projet

```
gestedu/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   ├── Models/
├── bootstrap/
├── config/
├── database/
│   └── migrations/
├── public/
├── resources/
│   ├── views/
│       ├── auth/
│       ├── components/
│       ├── dashboard/
│       ├── layouts/
│       ├── students/
│       ├── teachers/
│       ├── parents/
│       ├── attendance/
│       ├── examinations/
│       ├── schedules/
│       ├── payments/
├── routes/
│   └── web.php
└── .env
```

## Contact et support

Si vous rencontrez des problèmes lors de l'installation, n'hésitez pas à me contacter.