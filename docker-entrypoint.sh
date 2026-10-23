#!/bin/bash
set -e

# Update Apache port if PORT environment variable is set
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
fi

# Cache configuration, routes, and views
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run database migrations if DB is configured
if [ -n "$DB_HOST" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || true
fi

# Start Apache in foreground
exec apache2-foreground
