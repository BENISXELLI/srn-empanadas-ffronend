# Imagen base con PHP 8.1 y Apache
FROM php:8.1-apache

# Dependencias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip \
    git \
    curl \
    nano \
    && docker-php-ext-install intl \
    && a2enmod rewrite

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copiar solo composer files y ejecutar composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copiar el resto de la app
COPY . .

# Asegurar que las carpetas críticas existen y ajustar permisos
RUN mkdir -p /var/www/html/writable/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/writable \
    && chmod -R 755 /var/www/html/vendor

# Exponer puerto 80
EXPOSE 80
