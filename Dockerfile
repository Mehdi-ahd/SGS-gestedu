# Utiliser PHP 8.1 avec FPM
FROM php:8.1-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier le contenu du projet dans le conteneur
COPY . .

# Installer les dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Donner les bonnes permissions
RUN chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Ouvrir le port 8000
EXPOSE 8000

# Lancer le serveur Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
