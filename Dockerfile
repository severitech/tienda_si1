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
# # RUN php artisan config:clear && php artisan route:clear && php artisan view:clear
# RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# # Asignar permisos necesarios
# RUN chown -R www-data:www-data storage bootstrap/cache

# # Exponer puerto 80
# EXPOSE 80

# # Iniciar Apache
# CMD ["apache2-foreground"]
# Etapa 1: Build frontend local (fuera del Dockerfile)
# ---------------------------------------------------
# Ejecuta en tu máquina local:
# npm install
# NODE_OPTIONS="--max-old-space-size=2048" npm run build
#
# Esto genera el directorio `public/build` listo para producción.

# Etapa 2: Docker PHP + Apache para Laravel optimizado
FROM php:8.2-apache

# Suprimir warning Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Instalar dependencias PHP necesarias y limpiar cache apt
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libcurl4-openssl-dev libonig-dev libxml2-dev default-mysql-client \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip curl xml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar solo archivos PHP y configuración
COPY composer.json composer.lock ./
COPY app app
COPY bootstrap bootstrap
COPY config config
COPY database database
COPY resources/views resources/views
COPY routes routes
COPY storage storage
COPY artisan ./
COPY webpack.mix.js vite.config.js .env.example .env ./

# Instalar dependencias PHP sin dev y con optimización
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copiar el build frontend generado localmente
COPY public/build public/build
COPY public/index.php public/index.php
COPY public/css public/css
COPY public/js public/js
COPY public/mix-manifest.json public/mix-manifest.json

# Cambiar DocumentRoot a /var/www/html/public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Permitir acceso al directorio public con overrides (para .htaccess)
RUN echo "<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

# Limpiar caches Laravel (opcional pero recomendado)
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Ajustar permisos para storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]

