#!/bin/sh
set -e
cd /var/www/html

if [ "$1" = "php-fpm" ]; then
    [ -f .env ] || cp .env.example .env

    if [ ! -f vendor/autoload.php ]; then
        composer install --no-interaction --prefer-dist
    fi

    grep -q '^APP_KEY=base64' .env || php artisan key:generate --force

    echo "Waiting for database..."
    until php -r 'new PDO("mysql:host=".getenv("DB_HOST").";port=".getenv("DB_PORT").";dbname=".getenv("DB_DATABASE"), getenv("DB_USERNAME"), getenv("DB_PASSWORD"));' 2>/dev/null; do
        sleep 2
    done

    mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
    php artisan migrate --force
    if [ "$(php artisan tinker --execute='echo \App\Models\User::count();' 2>/dev/null | tail -1)" = "0" ]; then
        php artisan db:seed --force
    fi
    php artisan optimize:clear >/dev/null 2>&1 || true
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
    chmod -R ug+rwX storage bootstrap/cache
fi

exec "$@"
