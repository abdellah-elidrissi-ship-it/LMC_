#!/bin/sh
set -e

# Les variables d'env (APP_KEY, DB_*, CLOUDINARY_*, ...) sont injectées par
# Render au démarrage du conteneur, donc le cache config/routes/vues doit
# être (re)généré ici plutôt qu'au build de l'image.
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link || true

# Migrations volontairement NON automatiques ici — à lancer manuellement
# depuis le shell Render : php artisan migrate --force

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
