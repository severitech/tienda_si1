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
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        curl \
        xml \
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
COPY <<EOF /usr/local/bin/start-apache.sh
#!/bin/bash
# Configurar puerto dinámicamente
PORT=\${PORT:-80}
sed -i "s/Listen 80/Listen \$PORT/g" /etc/apache2/ports.conf
sed -i "s|<VirtualHost \*:80>|<VirtualHost \*:\$PORT>|" /etc/apache2/sites-available/000-default.conf

# Limpiar cache si es necesario
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar Apache
apache2-foreground
EOF

RUN chmod +x /usr/local/bin/start-apache.sh

# Exponer puerto variable
EXPOSE \$PORT

# Usar script de inicio
CMD ["/usr/local/bin/start-apache.sh"]
