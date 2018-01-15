#!/bin/bash

sudo su

apt-get update

apt-get install apache2 -y
apt-get install php7.0 -y
apt-get install php7.0-xml -y
apt-get install composer -y

cd /var/www/html/

php bin/console server:run