FROM dunglas/frankenphp:1-php8.5-alpine

RUN apk add --no-cache git bash

RUN install-php-extensions \
    pdo_pgsql \
    opcache \
    xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
