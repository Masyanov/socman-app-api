FROM php:8.3-fpm

# Install system dependencies and Node.js + npm for svgo
RUN apt-get update && apt-get install -y --no-install-recommends \
    jpegoptim optipng pngquant gifsicle \
    nodejs npm \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && npm install -g svgo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
