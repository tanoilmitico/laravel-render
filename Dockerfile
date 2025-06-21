# Usa immagine PHP 8.2 con Apache
FROM php:8.2-apache

# Installa dipendenze e estensioni PHP necessarie
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Abilita mod_rewrite di Apache (importante per Laravel)
RUN a2enmod rewrite

# Copia la configurazione Apache personalizzata
COPY docker/laravel.conf /etc/apache2/sites-available/000-default.conf

# Copia tutto il progetto nella root di Apache
COPY . /var/www/html

# Setta i permessi sulle cartelle storage e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Installa Composer (usa la versione ufficiale)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installa le dipendenze PHP con Composer
RUN composer install --optimize-autoloader --no-dev

# Espone la porta 80
EXPOSE 80

# Avvia Apache in foreground
CMD ["apache2-foreground"]

