# Dockerfile
# Use the official PHP image with Apache and install necessary extensions
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
#RUN apt-get update && apt-get install -y \
#    git \
#    unzip \
#    libpq-dev \
#    libzip-dev \
#    zip \
#    && docker-php-ext-install pdo_mysql zip

RUN docker-php-ext-install pdo pdo_mysql bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install Symfony dependencies
#RUN composer install --prefer-dist --no-scripts --no-dev --no-interaction --optimize-autoloader

# Expose the port that Apache is listening on
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
