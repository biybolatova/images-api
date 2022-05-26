FROM php:8.1-fpm
WORKDIR '/app'

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php8.1-mysql; \
    docker-php-ext-install pdo_mysql; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
