FROM php:8.2-apache

COPY apache2.conf /etc/apache2/apache2.conf
RUN apt-get update -y && apt-get upgrade -y
RUN a2enmod rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli