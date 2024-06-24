FROM php:8.2-fpm

# Install packages
RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      supervisor \
      git && \
      docker-php-ext-install pdo_pgsql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
COPY ./ /var/www
WORKDIR /var/www

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./_docker/app/laravel-worker.conf /etc/supervisor/conf.d/

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#RUN composer install --no-interaction

CMD php-fpm

EXPOSE 9000
