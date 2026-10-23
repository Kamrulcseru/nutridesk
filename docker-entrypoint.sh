#!/bin/bash
set -e

# Fallback APP_KEY if not provided
if [ -z "$APP_KEY" ]; then
    export APP_KEY="base64:eWSEqEmj6pT9UumlVy3FShuia6BGRekPx0JYSgWm+XE="
fi

# Update Apache port if PORT environment variable is set by Render
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
fi

# Ensure storage directories exist and are writable
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/logs
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Clear cached configurations
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run database migrations and seeds if DB_HOST is configured
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "127.0.0.1" ]; then
    echo "Connecting to DB_HOST: $DB_HOST..."
    php artisan migrate --force || true
    php artisan db:seed --class=NutriDeskSeeder --force || true
fi

# Start Apache in foreground
exec apache2-foreground
