----------------
how install neosuniversity-back
https://getgrav.org/blog/macos-catalina-apache-multiple-php-versions
https://uniwebsidad.com/foro/pregunta/1419/error-de-memoria-con-composer/
https://symfony.es/pagina/descargar/#installer-mac
----------------

Execute the next commands but remenber that you must have installed homebrew
when you exceute the netx commands you must see the next output

$ brew update
Already up-to-date.

$ brew upgrade
Updating Homebrew...

$ brew install gcc
$ xcode-select --install

------
when you try to execute the next commands you should get, the next messages -->

$ brew tap homebrew/dupes
Updating Homebrew...
Error: homebrew/dupes was deprecated. This tap is now empty as all its formulae were migrated.

$ brew tap homebrew/versions
Updating Homebrew...
Error: homebrew/dupes was deprecated. This tap is now empty as all its formulae were migrated.

----
That errors are related to deprecated version  in ordert to try to install php, so you need to execute the next commands-->

$ brew tap exolnet/homebrew-deprecated
$ brew install php@7.0
$ php -v
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/

put in you .bashprofile or .zshrc
alias composer="php /usr/local/bin/composer.phar"
save and exit

- execute the next command
$ composer install

if you get any error please take a look at the next steps:

$ rm composer.lock  --> you should be at thhe root of project
$ cd /etc
$ sudo cp php.ini.default php.ini
$ sudo chmod +w php.ini

--> Go to the project at config->config.yml and change original content secction to
# Doctrine Configuration
doctrine:
driver:  'pdo_mysql'

--> Go to the project at config-->parameters.yml and change original content secction to
arameters:
    database_host: 127.0.0.1

Now execute -->
$ php -d memory_limit=-1  /usr/local/bin/composer.phar install
$ php bin/console server:run
[OK] Server listening on http://127.0.0.1:8000


 // Quit the server with CONTROL-C.

PHP 7.3.9 Development Server started at Sat Jul 11 18:00:45 2020
Listening on http://127.0.0.1:8000
Document root is /Users/hhugohm/code/neosuniversity/neosuniversity-back/web
Press Ctrl-C to quit.

--> Go to you browser and execute --> 
http://localhost:8000/api/getcourse












