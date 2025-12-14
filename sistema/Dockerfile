FROM php:8.4-apache

# Instala git, unzip e Composer
RUN apt-get update && apt-get install -y git unzip curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala a extensão sockets (usada pelo php-amqplib)
RUN docker-php-ext-install sockets

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

RUN a2enmod rewrite

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2dissite 000-default.conf
RUN a2ensite 000-default.conf

EXPOSE 80