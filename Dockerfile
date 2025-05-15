# Start from PHP 8.2 FPM image
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && \
    apt-get install -y \
        git \
        curl \
        unzip \
        zip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libpq-dev \
        nginx \
        supervisor \
        netcat-openbsd && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-configure zip && \
    docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy configuration files
COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Expose HTTP port
EXPOSE 80

# Start script
CMD ["/bin/bash", "/start.sh"]
