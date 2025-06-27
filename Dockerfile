FROM php:8.2-apache

# Suprimir advertencia de Apache: AH00558
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Habilitar mod_rewrite (necesario para Laravel)
RUN a2enmod rewrite

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        curl \
        xml \
        gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar Composer desde imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar los archivos de la aplicación
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Cambiar el DocumentRoot de Apache a /var/www/html/public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Asegurar que Apache permita acceso al directorio public
RUN echo "<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

# Asignar permisos necesarios
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Crear script de inicio
RUN echo '#!/bin/bash\n\
PORT=${PORT:-80}\n\
echo "Configurando Apache en puerto: $PORT"\n\
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf\n\
sed -i "s|<VirtualHost \\*:80>|<VirtualHost \\*:$PORT>|" /etc/apache2/sites-available/000-default.conf\n\
php artisan config:clear\n\
php artisan cache:clear\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
exec apache2-foreground' > /usr/local/bin/start-apache.sh

RUN chmod +x /usr/local/bin/start-apache.sh

# Exponer puerto 80 (Railway manejará el dinámico)
EXPOSE 80

# Usar script de inicio
CMD ["/usr/local/bin/start-apache.sh"]
