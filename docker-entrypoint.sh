#!/bin/sh
set -e

echo "🚀 Démarrage de l'application Laravel..."

# Attendre que la base de données MySQL soit prête
echo "⏳ Attente de la connexion à MySQL..."
until php artisan migrate:status > /dev/null 2>&1; do
    echo "   Base de données non accessible, nouvelle tentative dans 3 secondes..."
    sleep 3
done

echo "✅ Connexion à MySQL établie"

# Exécuter les migrations
echo "📊 Exécution des migrations..."
php artisan migrate --force

# Créer le lien de stockage pour les fichiers publics
echo "🔗 Création du lien de stockage..."
php artisan storage:link

# Vider et reconstruire le cache pour Laravel 12
echo "🗂️ Nettoyage et reconstruction du cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache

# Créer la clé si elle n'existe pas
if [ ! -f .env ]; then
  cp .env.example .env
fi

php artisan key:generate --force

# Vérifie que les dossiers sont là
mkdir -p storage/logs storage/framework/{cache/data,sessions,views} bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Optimiser pour la production si nécessaire
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Optimisation pour la production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
fi

echo "✨ Application Laravel prête!"

# Exécuter la commande passée au script
exec "$@"
