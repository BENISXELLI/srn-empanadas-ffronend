FROM php:8.1-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    nano \
    && docker-php-ext-install intl \
    && a2enmod rewrite

# 📌 Establecer DocumentRoot en /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Actualizar configuración de Apache para usar la carpeta public/
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 📌 Ajustar permisos de la carpeta writable
RUN mkdir -p /var/www/html/writable && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html

# Habilitar mod_rewrite para URLs amigables de CodeIgniter
RUN a2enmod rewrite