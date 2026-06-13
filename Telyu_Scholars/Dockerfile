# Step 1: Base image containing PHP and Node extension tools
FROM php:8.2-fpm-alpine

# Step 2: Install system tools, Node.js (for Tailwind v4 compiling), and MySQL drivers
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm

RUN docker-php-ext-install pdo_mysql bcmath gd zip

# Step 3: Pull the latest Composer binary directly into the container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 4: Establish our working directory inside the container
WORKDIR /var/www/html

# Step 5: Copy your Laravel project into the container
COPY . .

# Step 6: Install your PHP packages and compile your Tailwind v4 styles via Vite
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Step 7: Give the web server permission to read/write Laravel storage folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Step 8: Expose standard web port
EXPOSE 80

# Step 9: Fire up Laravel's built-in engine bound to Render's dynamic port system
CMD php artisan serve --host 0.0.0.0 --port=$PORT