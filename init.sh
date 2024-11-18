#!/bin/bash

until nc -z -v -w30 db 3306
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
