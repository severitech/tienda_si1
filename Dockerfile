# Usamos la imagen oficial de PHP con Apache y extensiones necesarias
FROM php:8.1-apache

# Instalar dependencias necesarias y extensiones para Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar archivos de proyecto al contenedor
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias PHP sin paquetes de desarrollo
RUN composer install --no-dev --optimize-autoloader

# Ejecutar caches de Laravel
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Dar permisos a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer puerto 80 para el contenedor
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]
