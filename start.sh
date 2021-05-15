#!/bin/bash

wait-for-it db-user:3306 -t 120
cd /var/www/html/user
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate