# 1. Imagen oficial de PHP con Apache
FROM php:8.2-apache

# 2. Instalamos extensiones necesarias para Laravel y SQLite
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    sqlite3 \
    libsqlite3-dev

# 3. Limpiamos cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. Instalamos extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# 5. Habilitamos mod_rewrite
RUN a2enmod rewrite

# 6. Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Copiamos los archivos del proyecto
WORKDIR /var/www/html
COPY . .

# 8. Instalar dependencias de producción (CRÍTICO - faltaba esto)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 9. Crear SQLite y aplicar permisos
RUN mkdir -p database && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache database

# 10. DocumentRoot a /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 11. Migrar y arrancar al iniciar el contenedor
CMD php artisan migrate --force && \
    php artisan db:seed --force && \
    apache2-foreground

# 12. Puerto Apache
EXPOSE 80