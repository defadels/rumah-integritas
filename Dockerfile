FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nano \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    zip \
    curl

# Install PHP extensions
RUN docker-php-ext-install gd pdo pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-enable gd pdo pdo_mysql zip


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Aktifkan mod_rewrite Apache (penting untuk Laravel)
# RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
