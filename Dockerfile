FROM php:apache-buster

LABEL maintainer="Junki Kizuka <k.falconws@gmail.com>"

ENV DEBIAN_FRONTEND=noninteractive
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY composer.json /var/www/html/
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip
RUN composer install