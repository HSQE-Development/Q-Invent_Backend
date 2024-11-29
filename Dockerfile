# Usar PHP 8.3.11 como base
FROM php:8.3.11-fpm

WORKDIR /app

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y wget \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    curl \
    libxml2-dev \
    wget https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh -O /usr/local/bin/wait-for-it.sh \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip xml

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Clear cache

COPY . .

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader --no-interaction || { echo "Composer install failed"; exit 1; }
# Exponer el puerto 9000 para que Nginx pueda comunicarse con PHP-FPM
EXPOSE 9000

# Comando por defecto para iniciar PHP-FPM
CMD ["php-fpm"]