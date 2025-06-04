# Imagen base con PHP y Apache
FROM php:8.2-apache

# Instala extensiones y herramientas necesarias
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia los archivos del proyecto
COPY . /var/www/html

# Establece directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Permisos adecuados para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80

# Inicia el servidor con Laravel
CMD /bin/sh -c "mkdir -p /data && cp database/database.sqlite /data/database.sqlite && php artisan migrate --force && php -S 0.0.0.0:80 -t public"
