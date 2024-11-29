# Usar PHP 8.3.11 como base
FROM php:8.3.11-fpm

WORKDIR /var/www

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    git \
    unzip \
    curl \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip xml

# Instalar Composer (gestor de dependencias PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www

# Cambiar la propiedad de todos los archivos al usuario www-data
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

USER root
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Cambiar la propiedad nuevamente al usuario www-data para la ejecución
RUN chown -R www-data:www-data /var/www

USER www-data
# Exponer el puerto 9000 para que Nginx pueda comunicarse con PHP-FPM
EXPOSE 9000

# Comando por defecto para iniciar PHP-FPM
CMD ["php-fpm"]