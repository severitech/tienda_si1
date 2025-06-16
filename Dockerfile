# FROM php:8.2-apache

# # Suprimir advertencia de Apache: AH00558
# RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# # Habilitar mod_rewrite (necesario para Laravel)
# RUN a2enmod rewrite

# # Instalar dependencias del sistema y extensiones PHP necesarias
# RUN apt-get update && apt-get install -y \
#     git \
#     unzip \
#     zip \
#     libzip-dev \
#     libcurl4-openssl-dev \
#     libonig-dev \
#     libxml2-dev \
#     default-mysql-client \
#     && docker-php-ext-configure zip \
#     && docker-php-ext-install \
#         pdo \
#         pdo_mysql \
#         mbstring \
#         zip \
#         curl \
#         xml \
#     && apt-get clean && rm -rf /var/lib/apt/lists/*

# # Establecer directorio de trabajo
# WORKDIR /var/www/html

# # Copiar Composer desde imagen oficial
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # Copiar los archivos de la aplicación
# COPY . .

# # Instalar dependencias de PHP
# RUN composer install --no-dev --optimize-autoloader --no-interaction

# # Cambiar el DocumentRoot de Apache a /var/www/html/public
# RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# # Asegurar que Apache permita acceso al directorio public
# RUN echo "<Directory /var/www/html/public>\n\
#     Options Indexes FollowSymLinks\n\
#     AllowOverride All\n\
#     Require all granted\n\
# </Directory>" >> /etc/apache2/apache2.conf

# # Cache de configuración de Laravel (opcional durante testing)
# RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# # Asignar permisos necesarios
# RUN chown -R www-data:www-data storage bootstrap/cache

# # Exponer puerto 80
# EXPOSE 80

# # Iniciar Apache
# CMD ["apache2-foreground"]

# Etapa 1: PHP + Composer (sin node ni npm)
FROM php:8.2-fpm

# Instalar extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libpq-dev mariadb-client \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Instalar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar composer.json y composer.lock
COPY composer.json composer.lock ./

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Copiar todo el proyecto, excepto node_modules y public/build
COPY . .

# Copiar los assets compilados localmente (Vite build)
COPY public/build public/build

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080
CMD ["php-fpm"]

