FROM php:8.2-apache

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1
ENV COMPOSER_HOME /composer

RUN mkdir /app
WORKDIR /app

RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /app
COPY ./docker/local/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/local/php/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN composer install && \
    php artisan cache:clear && \
    php artisan config:clear

RUN chmod 777 -R storage && \
    echo "Listen 8080" >> /etc/apache2/ports.conf  && \
    a2enmod rewrite

CMD ["apache2-foreground"]