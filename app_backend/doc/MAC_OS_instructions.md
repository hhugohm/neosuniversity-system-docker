Prerrequisites
==

Install Homebrew

Command Line Tools (CLT) for Xcode:

```
 $ xcode-select --install
```

Install brew using command line
```
$ /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

Install MySQL
===================

At this time of writing, Homebrew has MySQL version 5.7.15 as default
 in its main repository :
*	Enter the following command : 
```
 $ brew info mysql
 ```
 
*	Expected output: mysql: stable 5.7.15 (bottled)

To install MySQL enter : 
```
$ brew install mysql
```

Additional configuration
Homebrew
*	Install brew services first :
```
     $ brew tap homebrew/services
```
*	Load and start the MySQL service :
```
      $ brew services start mysql
```

Expected output : Successfully started mysql (label: homebrew.mxcl.mysql)

*	Check of the MySQL service has been loaded : 
   $ brew services list 1
*	Verify the installed MySQL instance :
```
 $ mysql -V
```
Expected output : Ver 14.14 Distrib 5.7.15, for osx10.12 (x86_64)

MySQL
Open Terminal and execute the following command to set the root password:
```
  $ mysqladmin -u root password 'discom'
```
Important : Use the single ‘quotes’ to surround the password and make sure to select a strong password!

Database Management

To manage your databases, I recommend using Sequel Pro, a MySQL management tool designed for macOS.


Install Frontend Services
=========

```
$ git clone https://gitlab.com/neosuniversity/neosuniversity-back.git
$ git fetch
$ git checkout development
```

Run database scripts
===================

```
$ cd neosuniversity-back/scriptsSQL
$ mysql -u root -p

(Enter pwd)

mysql> source database.sql
```

Install PHP
==

```
$brew update && brew upgrade
$brew tap homebrew/dupes
$brew tap homebrew/versions
$brew tap homebrew/homebrew-php
$brew install php70
```

Install composer

```
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/
```

Modify .bash_profile

```
$ cd
$ cp .bash_profile .bash_profile_back
$ vim .bash_profile
```

add the next line at the end of file
```
alias composer="php /usr/local/bin/composer.phar"
```

save and exit

Symfony install
==

```
curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
chmod a+x /usr/local/bin/symfony
```

Install dependencies
```
$ cd neosuniversity-back

$ mkdir var

$ composer install
```


Run the project
===============
```
$ cd neosuniversity-back
$ php bin/console server:run
```

open your browser http://localhost:8000/api/course

you will see json response


now in another terminal run
to review the logs related with the application

```
$ tail -1000f var/logs/dev.log
```

```
review the logs it is going to show something like this_
´[2017-11-28 20:36:34] doctrine.DEBUG: SELECT t0_.id AS id_0, t0_.courseName AS courseName_1, t0_.numbClasses AS numbClasses_2, t0_.numHrsVideo AS numHrsVideo_3, t0_.courseDesc AS courseDesc_4, t0_.isFree AS isFree_5, t0_.cost AS cost_6, t0_.author_id AS author_id_7 FROM tc_course t0_ [] []
[2017-11-28 20:36:34] doctrine.DEBUG: SELECT t0.id AS id_1, t0.name AS name_2, t0.lastName AS lastName_3, t0.title AS title_4, t0.resume AS resume_5 FROM tc_author t0 WHERE t0.id = ? [1] []´
```

it will show a JSON response



Common commands
===============

The way to configure database connection is modifying parameters.yml

```
php bin/console debug:container
```

show all routes
```
php bin/console debug:router

php bin/console cache:clear
```

To generate PHP doc (source documentation)
=========================================
```
$ wget http://phpdox.de/releases/phpdox.phar

$ chmod +x phpdox.phar

$  mv phpdox.phar /usr/local/bin/phpdox

$phpdox --version

phpDox 0.8.0 - Copyright (C) 2010 - 2015 by Arne Blankerts


after that run (it reads phpdox.xml)
$phpdox
```

Happy Code on Neosuniversity backend
==