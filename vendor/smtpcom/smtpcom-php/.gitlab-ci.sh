#!/bin/bash

# Install system packages required by Composer.
apt-get update -yqq
apt-get install git unzip -yqq

# Install Composer and project dependencies.
curl -sS https://getcomposer.org/installer | php
php composer.phar install
