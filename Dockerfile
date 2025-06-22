# Imagen base con PHP y Apache
FROM php:8.2-apache

# Instala extensiones necesarias (ahora para PostgreSQL)
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia los archivos del proyecto
COPY . /var/www/html

# Establece directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias
RUN composer install --optimize-autoloader --no-dev

# Permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80

# Comando de arranque sin SQLite
CMD /bin/sh -c "php artisan migrate --force && php -S 0.0.0.0:80 -t public"
