# ===============================
# Stage 0 - Composer
# ===============================
FROM composer:2.7.7 AS vendor

WORKDIR /app
COPY . .

RUN mkdir -p bootstrap/cache \
    storage \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    && chmod -R 777 bootstrap/cache storage

RUN composer install --no-dev --optimize-autoloader
RUN composer dump-autoload --optimize


# ===============================
# Stage 1 - Frontend (Vite)
# ===============================
FROM node:24-alpine AS frontend

WORKDIR /app
COPY --from=vendor /app /app

RUN npm install
RUN npm run build


# =====================================
# Stage 2 - Backend (Laravel + Nginx)
# =====================================
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    git curl unzip \
    postgresql-dev \
    oniguruma-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip

WORKDIR /var/www

COPY --from=vendor /app /var/www
COPY --from=frontend /app/public/build ./public/build

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN chown -R www-data:www-data /var/www \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
