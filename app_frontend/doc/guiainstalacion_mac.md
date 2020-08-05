**Install Software**

NPM 
==
Download and install 
https://nodejs.org/dist/v10.15.1/node-v10.15.1.pkg

Validate the installation

```
$ node -v
```

it whill show something like this:

```
neossoftware@neossoftware:~/development/neossoftware$ node -v
v7.10.1
```

Install bower and grunt
==

```
$ sudo npm install bower -g
$ sudo npm install grunt-cli -g
```

test installation:
```
$ bower -v


neossoftware@neossoftware:~/development/neossoftware$ bower -v
1.8.2

$ grunt -version

neossoftware@neossoftware:~/development/neossoftware$ grunt -version
grunt-cli v1.2.0
```


download source code
=========

```
$ git clone https://gitlab.com/neosuniversity/neosuniversity.git
```

Please use  development branch
==

_________________________________________________
Download dependencies and execute the application
_________________________________________________
Execute  the following commands:

```
$ cd neosuniversity
```

Install npm dependencies to run grunt and http server

```
$ npm install
```

Install CSS and JS dependencies
```
$ bower install
```

At this point it is necessary to modify  the file src/js/config.js
it has:

```javascript
.constant('API', { 
    //APIURL: "http://localhost/codeigniter/cijwt",
    //APIURL: "http://192.168.0.30/api/web"
    // APIURL: "http://localhost/api/web/app_dev.php"
    APIURL: "https://www.neosuniversity.com/neosuniversity-back/web"
   })
```
in local your code should be:

```javascript
.constant('API', { 
     APIURL: "http://localhost/api/web/app_dev.php"
   })
```
Important don't upload this change to development branch.


Build Angular Version
```
$ grunt build:angular
```

Start front end application

```
$ npm start
```
open your browser  http://localhost:8080/src/

It will show the login page

please use the following credentials:

```
user: mario.hidalgom@yahoo.com.mx
pwd: N30sdiscom18
```

Happy Code!!
=======
