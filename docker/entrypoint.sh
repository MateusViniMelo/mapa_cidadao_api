#!/bin/sh
set -e

echo "Clearing caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true


echo "Caching config..."
php artisan config:cache || true

echo "Caching routes..."
php artisan route:cache || true

echo "Caching views..."
php artisan view:cache || true

echo "Caching events..."
php artisan event:cache || true

echo "Running migrations..."
php artisan migrate --force || true

echo "Running database seeders..."
php artisan db:seed --force || true

echo "Linking storage..."
php artisan storage:link || true

exec "$@"
