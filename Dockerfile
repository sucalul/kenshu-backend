FROM php:8-apache

RUN apt-get update
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo_pgsql

COPY ./configs/php/php.ini /usr/local/etc/php/
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install

# 参考
# https://qiita.com/YAJIMA/items/68de1bdeb71a921a718d
RUN a2enmod rewrite \
    && service apache2 restart
