FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt update && \
  apt upgrade -y && \
  apt install software-properties-common -y && \ 
  add-apt-repository ppa:ondrej/php && \
  apt update && \
  apt install apache2 -y  && \
  apt install php8.2 -y &&  \ 
  apt install php-xml -y && \
  apt install composer -y && \
  apt install mysql-server -y && \
  apt install nodejs -y && \
  apt install npm -y && \
  apt install vim -y

EXPOSE 80

WORKDIR /var/www/html

ENTRYPOINT /etc/init.d/apache2 start && \
  /etc/init.d/mysql start && \
  /bin/bash

CMD [ "true" ]
