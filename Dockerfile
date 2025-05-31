FROM php:8.2.10-apache


RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    sqlite3 \
    libsqlite3-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_sqlite zip mbstring tokenizer xml curl

RUN a2enmod rewrite

WORKDIR /var/www/html

# Copiar solo archivos para composer
COPY composer.json composer.lock ./

# Instalar composer (de la imagen oficial)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --verbose


# Ahora copiar el resto de la app
COPY . .

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
