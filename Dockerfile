FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    libpq-dev \
    curl

# Install PHP extensions (pdo_pgsql wajib untuk Postgres)
RUN docker-php-ext-install pdo pdo_pgsql bcmath

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy code
COPY . .

# Ownership setup
RUN chown -R www-data:www-data /var/www
