
Steps to configure Neosuniversity Front End in Ubuntu 16.04
===============================================
1) Install Node JS
===============================================

Add Node.js 7.x repository

$sudo curl -sL https://deb.nodesource.com/setup_7.x | bash -

$sudo apt-get install -y nodejs

validate the installation

$ node -v

it whill show something like this:

neossoftware@neossoftware:~/development/neossoftware$ node -v
v7.10.1
============================
Install bower and grunt
============================

$ sudo npm install bower -g
$ sudo npm install grunt-cli -g

test installation:
$ bower -v

neossoftware@neossoftware:~/development/neossoftware$ bower -v
1.8.2

$ grunt -version

neossoftware@neossoftware:~/development/neossoftware$ grunt -version
grunt-cli v1.2.0
=====================
download source code
====================

$ git clone https://gitlab.com/neosuniversity/neosuniversity.git

**Please use de development branch**

$ cd neosuniversity
===============================================
Download dependencies and execute the application
==============================================
Execute  the following commands:

Install npm dependencies to run grunt and http server
$ npm install

Install CSS and JS dependencies
$ bower install

Build Angular Version
$ grunt build:angular

Start front end application
$ npm start

open your browser  http://localhost:8080/src/

It will show the login page

please use the following credentials:
user: mario.hidalgom@yahoo.com.mx
pwd: N30sdiscom18
==========================
 Recommendations:
=========================
**Use Visual Code or sublime**

$curl https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > microsoft.gpg
$sudo mv microsoft.gpg /etc/apt/trusted.gpg.d/microsoft.gpg
$sudo sh -c 'echo "deb [arch=amd64] https://packages.microsoft.com/repos/vscode stable main" > /etc/apt/sources.list.d/vscode.list'

Then update the package cache and install the package using:

$sudo apt-get update
$sudo apt-get install code # or code-insiders



Documents related with the template is located in "src/tpl/docs.html" 

online: http://flatfull.com/themes/angulr/angular/#/app/docs


INformacion para parsear en la vista

TwSection
	classescompleted: 0
	control_panel_id: 17
	section: {…}
	   classes: Array [ {…}, {…}, {…} ]
	   course_id: 1
	   description: "Introducción a Git"
	   id: 1
	   numberclasses: 3
	   sectionnumber: 1
	section_id: 1
	tw_classes: Array [  ]
     	0: {…}
    	TwClase
    	clase: {…}
      		activitytype: 1
			class_id: 1
			classdescription: "Usando Git en el control de versiones"
			section: Object { id: 1, course_id: 1, sectionnumber: 1, … }
			section_id: 1
			videourl: "http://youtube.com/neosuniversity/fdfdf?32434"
        class_id: 1
        control_panel_id: 17
        iscompleted: "0"
       section_id: 1


        <div class="panel panel-default">
                       <div class="panel-heading">

                       </div>
                       <iframe src="//player.vimeo.com/video/248399799?api=1" width="700" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>


                       <script>

                       </script>
                   </div>

###############################
Ejecucion de Docker
$ docker build --tag neos-front:1.0 .
$ docker run  --publish 8080:8080 --detach --name front-app  neos-front:1.0

browser --> http://localhost:8080/src