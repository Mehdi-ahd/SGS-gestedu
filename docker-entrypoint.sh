#!/bin/sh
set -e

echo "🚀 Démarrage de l'application Laravel..."
echo "➡️ Environnement détecté : $APP_ENV"
echo "➡️ Base de données : $DB_CONNECTION"

if [ "$DB_CONNECTION" = "mysql" ]; then
    echo "⏳ Attente de MySQL..."
    until php artisan migrate:status > /dev/null 2>&1; do
        echo "   Base MySQL non prête, nouvelle tentative dans 3 secondes..."
        sleep 3
    done
    echo "✅ MySQL prêt"
else
    echo "🗄️ Environnement SQLite détecté"

    # Création du fichier si manquant
    if [ ! -f "$DB_DATABASE" ]; then
        echo "📄 Création du fichier SQLite : $DB_DATABASE"
        touch "$DB_DATABASE"
    fi

    # Permissions
    chown -R www-data:www-data $(dirname "$DB_DATABASE")
    chmod -R 775 $(dirname "$DB_DATABASE")

    echo "✅ SQLite prêt"
fi

echo "📊 Exécution des migrations..."
php artisan migrate --force

echo "🔗 Création du lien de stockage..."
php artisan storage:link || true

echo "🗂️ Nettoyage du cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache

echo "✨ Application Laravel prête!"

exec "$@"
