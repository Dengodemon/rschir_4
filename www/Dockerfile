FROM php:7.2-apache
RUN apt-get update && docker-php-ext-install mysqli
RUN apt-get -y install libaprutil1-dbd-mysql && a2enmod authn_dbd