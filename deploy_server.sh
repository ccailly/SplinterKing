#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    # Update codebase
    git fetch origin deploy
    git reset --hard origin/deploy

    # Copy .env file
    cp /var/www/.env.splinterking /var/www/SplinterKing/.env

    # Install dependencies based on lock file
    composer install --no-interaction --prefer-dist --optimize-autoloader

    # Optimizing
    php artisan config:cache
    php artisan route:cache

    # Change owner
    sudo chown -R www-data:www-data /var/www/SplinterKing

    # Change permissions
    sudo chmod -R 775 /var/www/SplinterKing/storage

    # Reload PHP to update opcache
    echo "" | sudo systemctl reload apache2
# Exit maintenance mode
php artisan up

echo "Application deployed!"