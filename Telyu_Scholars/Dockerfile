# Step 1: Base image containing PHP and Node extension tools
FROM php:8.2-fpm-alpine

# Step 2: Install system tools and MySQL drivers
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql bcmath gd zip

# Step 3: Pull the latest Composer binary directly into the container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 4: Establish our working directory inside the container
WORKDIR /var/www/html

# Step 5: Copy your Laravel project into the container
COPY . .

# Step 6: Install your PHP packages securely for production
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Step 7: Give the web server permission to read/write Laravel storage folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Step 8: Expose standard web port
EXPOSE 80

# Step 9: Prepare paths, run migrations, cache files, establish symlink, and launch server
CMD mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    rm -f public/storage && \
    php artisan storage:link --force && \
    php -S 0.0.0.0:${PORT:-80} -t public