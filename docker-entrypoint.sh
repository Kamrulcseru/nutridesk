#!/bin/bash
set -e

# Fallback APP_KEY if not provided
if [ -z "$APP_KEY" ]; then
    export APP_KEY="base64:eWSEqEmj6pT9UumlVy3FShuia6BGRekPx0JYSgWm+XE="
fi

# Ensure MySQL and TiDB defaults if not set in Render
export DB_CONNECTION=${DB_CONNECTION:-mysql}
export DB_HOST=${DB_HOST:-gateway01.ap-southeast-1.prod.aws.tidbcloud.com}
export DB_PORT=${DB_PORT:-4000}
export DB_DATABASE=${DB_DATABASE:-nutridesk}
export DB_USERNAME=${DB_USERNAME:-45etxRRpQnM33me.root}
export DB_PASSWORD=${DB_PASSWORD:-FqKjkJjMQHE0Q1lG}
export MYSQL_ATTR_SSL_CA=${MYSQL_ATTR_SSL_CA:-/etc/ssl/certs/ca-certificates.crt}

# Update Apache port if PORT environment variable is set by Render
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
fi

# Create sqlite database file as fallback
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite
chmod 666 /var/www/html/database/database.sqlite

# Ensure storage directories exist and are writable
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/logs
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Clear cached configurations
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run database migrations and seeds
echo "Connecting to DB_HOST: $DB_HOST..."
php artisan migrate --force || true
php artisan db:seed --class=NutriDeskSeeder --force || true

# Start Apache in foreground
exec apache2-foreground
