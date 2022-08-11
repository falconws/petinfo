FROM php:apache-buster

LABEL maintainer="Junki Kizuka <k.falconws@gmail.com>"

ENV DEBIAN_FRONTEND=noninteractive
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY composer.json /var/www/html/
COPY docker/config/99-xdebug.ini /usr/local/etc/php/conf.d/
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN composer install