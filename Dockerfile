FROM php:8.1-apache

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html/

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN a2enmod rewrite

RUN sed -i 's/AllowOverride None/AllowOverride All/g' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 80