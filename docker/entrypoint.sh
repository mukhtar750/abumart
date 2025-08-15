#!/bin/sh

# Exit on any error
set -e

echo "Starting Laravel application setup..."

# Create necessary directories
mkdir -p /var/log/supervisor
mkdir -p /var/log/nginx
mkdir -p /var/log/php-fpm

# Create SQLite database if it doesn't exist
if [ "$DB_CONNECTION" = "sqlite" ]; then
    echo "Setting up SQLite database..."
    touch /var/www/html/database/database.sqlite
    chmod 664 /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
fi

# Set proper permissions
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# Generate application key if not exists
if [ ! -f /var/www/html/.env ]; then
    echo "No .env file found, copying from example..."
    cp /var/www/html/setup.env.example /var/www/html/.env
fi

# Generate application key
cd /var/www/html
php artisan key:generate --force || echo "Key already generated"

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Run migrations if database is available
php artisan migrate --force || echo "Migrations failed or not needed"

# Optimize for production
php artisan optimize

echo "Laravel application setup completed!"

# Execute the main command
exec "$@"
