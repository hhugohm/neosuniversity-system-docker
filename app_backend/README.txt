
Steps to install Neosuniversity backend
================================
1) MYSQL Server configuration
===============================
$ sudo apt-get install mysql-server

the installation ask root pwd pls dont forget ;)

test mysql server

$ mysql -u root -p 

it asks root pwd then it will show mysql prompt

myql>
========================================
MYSQL client (Optional)
========================================

You can use either mysql client
-MYSQL Workbench
-squirrel
even phpmyadmin 

Steps for mysql workbench

$ sudo apt install mysql-workbench

open mysql-workbench
$ mysql-workbench
=========================================
Database installation
========================================
run script neosuniversity-back/scriptsSQL/database.sql

a) using command line

   $ cd ../neosuniversity-back/scriptsSQL

   Access to mysql propmt

   mysql> source database.sql

b)Using mysql workbench

   Login in mysql using root, then copy paste mysql script select all script and click in Run selected portion ..
============================
Install Apache 
============================
$sudo apt-get -y install apache2

test in your browser http://localhost
==================
Install PHP 7
==================
$ sudo apt-get -y install php7.0 

Note : /etc/php/7.0/cli/php.ini  is the file configuration of PHP

Now install php 7 modules

$sudo apt-get -y install libapache2-mod-php7.0  php7.0-mysql php7.0-curl php7.0-gd php7.0-intl php-pear php-imagick php7.0-imap php7.0-mcrypt php-memcache php7.0-pspell php7.0-recode php7.0-sqlite3 php7.0-tidy php7.0-xmlrpc php7.0-xsl php7.0-mbstring php-gettext

restart apache
$ sudo systemctl restart apache2

Apache Security

Change the owner of www directory
$ sudo chown -R www-data:www-data /var/www

change the group permissions
$sudo chmod -R g+rwx /var/www

add your user to www-data group
for instance (neossoftware is my current user): 

$ sudo usermod -a -G www-data neossoftware

verify you can create a file in /var/www
nano /var/www/phpinfo.php
______________________________________________________
If nano show this error please restart your machine
[ Error writing lock file /var/www/.phpinfo.php.swp: Permission denied 
_______________________________________________________

after reboot
create a new php file
$nano /var/www/phpinfo.php

add next content:
<?php
phpinfo();
?>

now open your browser http://localhost/phpinfo.php
it will show php configuration
============================
Install  composer symfony
============================

$ sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
$ sudo chmod a+x /usr/local/bin/symfony

now verify that symfony installation works
$symfony -v

it will show symfony version

Now install composer:

$sudo apt-get update 

now install composer dependencies

$sudo apt-get install curl php-cli php-mbstring git unzip

Install Composer (PHP dependency manager)
$ cd ~
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

$ php -r "unlink('composer-setup.php');"

now try installation
$ composer -v
it will show composer version
====================================
Download source code and try backend
====================================

$ git clone https://gitlab.com/neosuniversity/neosuniversity-back.git

**Please use de development branch**

$ cd neosuniversity-back
$ mkdir var
$ composer install

after running the command please execute

$ git checkout -- app/config/parameters.yml

this is because composer change this file 

Now execute

$ php bin/console server:run 

now in another terminal run
to review the logs related with the application


$ tail -1000f var/logs/dev.log

review the logs it is going to show something like this_
´[2017-11-28 20:36:34] doctrine.DEBUG: SELECT t0_.id AS id_0, t0_.courseName AS courseName_1, t0_.numbClasses AS numbClasses_2, t0_.numHrsVideo AS numHrsVideo_3, t0_.courseDesc AS courseDesc_4, t0_.isFree AS isFree_5, t0_.cost AS cost_6, t0_.author_id AS author_id_7 FROM tc_course t0_ [] []
[2017-11-28 20:36:34] doctrine.DEBUG: SELECT t0.id AS id_1, t0.name AS name_2, t0.lastName AS lastName_3, t0.title AS title_4, t0.resume AS resume_5 FROM tc_author t0 WHERE t0.id = ? [1] []´

open your browser http://localhost:8000/api/course
it will show a JSON response 

neosuniversity-back
===================

A Symfony project created on June 2, 2017, 4:20 am.


The way to configure database connection is modifying parameters.yml


php bin/console debug:container


show all routes
php bin/console debug:router


php bin/console cache:clear

==========================================
To generate PHP doc (source documentation)
=========================================

$ wget http://phpdox.de/releases/phpdox.phar

$ chmod +x phpdox.phar

$ sudo mv phpdox.phar /usr/local/bin/phpdox

$phpdox --version

phpDox 0.8.0 - Copyright (C) 2010 - 2015 by Arne Blankerts

after that run (it reads phpdox.xml)
$phpdox