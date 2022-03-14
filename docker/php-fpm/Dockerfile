FROM composer:2.2.7

FROM php:8.1-fpm-alpine
RUN apk update && apk add bash libxml2-dev libzip-dev curl-dev autoconf gcc make g++ zlib-dev zstd-dev
RUN docker-php-ext-install pdo pdo_mysql xml zip curl
RUN pecl install igbinary ctype bcmath && docker-php-ext-enable igbinary
RUN yes | pecl install redis && docker-php-ext-enable redis
RUN yes | pecl install xdebug  && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >>  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=off" >>  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host = host.docker.internal" >>  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=0 /usr/bin/composer /usr/bin/composer
COPY wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it
CMD composer install; wait-for-it elasticsearch:9200 -t 0 -- bin/console app:feed-locations -i ship_positions.json; php-fpm
EXPOSE 9000
WORKDIR /app