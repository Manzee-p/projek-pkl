FROM php:8.2-fpm-alpine

RUN apk update && apk add \
    git \
    curl \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    postgresql-dev \
    libpq \
    build-base \
    imagemagick \
    && docker-php-ext-install pdo pdo_pgsql pgsql dom xml mbstring zip exif pcntl \
    && apk del build-base

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
