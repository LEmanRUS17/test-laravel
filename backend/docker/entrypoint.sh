#!/bin/sh
set -e

# База SQLite лежит в томе storage, при первом запуске файла ещё нет
mkdir -p "$(dirname "$DB_DATABASE")"
touch "$DB_DATABASE"
chown -R www-data:www-data storage

php artisan migrate --force
php artisan config:cache
php artisan route:cache

exec "$@"
