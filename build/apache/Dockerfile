####################################
# 06/JULY/2020                     #
# NEOSUNIVERSITY                   #
####################################
FROM    ubuntu:20.04

LABEL manteiner=“neosuniversity@gmail.com”

RUN apt  update
RUN DEBIAN_FRONTEND="noninteractive" apt-get -y install tzdata
ENV TZ=America/Mexico_City
RUN apt install -y apache2

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

COPY    ./app_frontend /var/www/app_frontend

# Update the default apache site with the config we created.
ADD ./build/apache/apache-config.conf /etc/apache2/sites-enabled/000-default.conf

RUN echo '########## APACHE DONE!!! ##########'  

RUN apt  install -y git-core
RUN apt  install -y nodejs
RUN apt  install -y npm


WORKDIR /var/www/app_frontend
RUN  npm config set strict-ssl false
RUN  npm cache clean -f
RUN npm install -g grunt-cli
RUN npm install -g grunt
RUN npm install -g bower

RUN npm install
RUN bower install --allow-root
RUN grunt build:angular --allow-root

RUN echo '########## NPM + BOWER + GRUNT DONE!!! ##########'  
# Expose apache.
EXPOSE 80
# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND
