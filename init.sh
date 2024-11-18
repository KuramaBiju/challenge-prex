#!/bin/bash

if( ! -f /app/vendor/autoload.php); then
    echo "Installing Composer dependecies"
    composer install --no-dev --optimize-autoloader
fi 

if( ! -f /app/.env); then
    echo "Creating .env file from .env.example..."
    cp /app/.env.example /app/.env
fi 

while ! nc -z -v -w30 db 3306
do
    echo "Waiting for database connection..."
    sleep 5
done

echo "Database connection established! Executing commands..."



php artisan key:generate
php artisan migrate --force
php artisan passport:install
php artisan db:seed

php artisan serve --host=0.0.0.0 --port=8000
