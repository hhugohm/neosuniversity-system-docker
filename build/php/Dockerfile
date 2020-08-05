####################################
# 06/JULY/2020                     #
# NEOSUNIVERSITY                   #
####################################
FROM php:7.3.12-fpm-stretch 

LABEL manteiner=“neosuniversity@gmail.com”

RUN apt-get update && apt-get install -y

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
    && docker-php-ext-install \
        zip \
        intl \
		mysqli \
        pdo pdo_mysql

RUN echo '########## PHP DONE!!! ##########'    

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update


RUN echo '########## COMPOSER DONE!!! ##########'

WORKDIR /var/www/app_backend

#ENTRYPOINT bash -c "composer install"


