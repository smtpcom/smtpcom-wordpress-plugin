#!/bin/bash

# Update packages and install composer and PHP dependencies.
apt-get update -yqq
apt-get install git unzip libcurl4-gnutls-dev libicu-dev libmcrypt-dev libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev libldap2-dev unixodbc-dev libpq-dev libaspell-dev libsnmp-dev libpcre3-dev libtidy-dev -yqq

# Compile PHP, include these extensions.
docker-php-ext-install curl json intl xml zip bz2 opcache

# Install Xdebug
pecl install xdebug
docker-php-ext-enable xdebug

# Install Composer and project dependencies.
curl -sS https://getcomposer.org/installer | php
php composer.phar install
