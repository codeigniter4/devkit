FROM php:8.1-fpm
COPY php.ini /usr/local/etc/php/

COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

RUN apt update && apt install -y libicu-dev libzip-dev \
    && docker-php-ext-install intl opcache mysqli \
    && docker-php-ext-configure zip && docker-php-ext-install zip \
    && pecl install apcu && docker-php-ext-enable apcu

WORKDIR /ci4proj
