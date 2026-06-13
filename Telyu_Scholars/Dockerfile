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

# Step 6: Install your PHP packages
RUN composer install --no-dev --optimize-autoloader

# Step 7: Give the web server permission to read/write Laravel storage folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Step 8: Expose standard web port
EXPOSE 80

# Step 9: Clear old configurations and start the built-in server
CMD php artisan config:clear && php artisan cache:clear && php -S 0.0.0.0:$PORT -t public