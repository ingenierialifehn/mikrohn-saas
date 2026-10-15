FROM php:8.3-fpm-alpine

# Instalar dependencias del sistema requeridas
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    libpng-dev \
    libzip-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    icu-dev \
    linux-headers

# Instalar instalador de extensiones PHP optimizado
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Instalar extensiones PHP necesarias para Laravel y MikroTik API
RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    sockets \
    opcache

# Instalar Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuración personalizada de PHP
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
