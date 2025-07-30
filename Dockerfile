
FROM php:8.2.18-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    default-mysql-client \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier composer.json et composer.lock en premier pour le cache Docker
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copier package.json et package-lock.json pour le cache Docker
COPY package*.json ./

# Installer les dépendances Node.js
#RUN npm ci --only=production

# Copier le reste des fichiers de l'application
COPY . .

# Construire les assets
#RUN npm run build

# Copier le fichier .env.example vers .env si .env n'existe pas
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Générer la clé d'application Laravel
RUN php artisan key:generate --no-interaction

# Créer les répertoires nécessaires et définir les permissions
RUN mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/storage/framework/cache/data \
    && mkdir -p /var/www/storage/framework/sessions \
    && mkdir -p /var/www/storage/framework/views \
    && mkdir -p /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Finaliser l'installation Composer (exécuter les scripts post-install)
RUN composer dump-autoload --optimize

# Exposer le port 8000
EXPOSE 8000

# Script de démarrage
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh \
    && sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

# Commande par défaut pour Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
