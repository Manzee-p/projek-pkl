FROM php:8.3-fpm


RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libpng-dev libonig-dev libxml2-dev zip libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


WORKDIR /var/www/html

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} deploy \
    && useradd -u ${UID} -g deploy -m deploy \
    && usermod -aG www-data deploy \
    && chown -R deploy:deploy /var/www/html

USER deploy


COPY --chown=deploy:deploy ./src ./


RUN composer install --no-dev --optimize-autoloader


RUN mkdir -p storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

CMD ["php-fpm"]
