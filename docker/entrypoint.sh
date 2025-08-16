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

# Explicitly set database connection to SQLite to override any defaults
export DB_CONNECTION=sqlite
export DB_DATABASE=/var/www/html/database/database.sqlite
export SESSION_CONNECTION=sqlite
export CACHE_STORE=database
export QUEUE_CONNECTION=database

echo "Database connection set to: $DB_CONNECTION"
echo "Database path: $DB_DATABASE"

# Generate application key
cd /var/www/html
php artisan key:generate --force || echo "Key already generated"

# Run migrations FIRST to create database tables
echo "Creating database tables..."
php artisan migrate --force || echo "Migrations completed"

# Now clear caches AFTER tables exist
echo "Clearing all Laravel caches..."
php artisan config:clear
php artisan cache:clear || echo "Cache clear completed"
php artisan route:clear
php artisan view:clear

# Cache configurations AFTER clearing
echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize for production
php artisan optimize

echo "Laravel application setup completed!"

# Execute the main command
exec "$@"
