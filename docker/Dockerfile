FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt update && \
    apt upgrade -y && \
    apt install software-properties-common -y && \ 
    add-apt-repository ppa:ondrej/php && \
    apt update && \
    apt install apache2 -y  && \
    apt install php8.2 -y &&  \ 
    apt install php8.2-mysqli -y && \
    apt install php8.2-mbstring -y && \
    apt install php php-mysql -y && \
    apt install php8.2-xml -y && \
    apt install php8.2-xdebug -y && \
    apt install composer -y && \
    apt install nodejs -y && \
    apt install npm -y && \
    npm install -g sass && \
    apt install vim -y 

COPY ./config-files/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite && service apache2 restart

EXPOSE 80

WORKDIR /var/www/html

ENTRYPOINT /etc/init.d/apache2 start && \
    /bin/bash

CMD [ "true" ]
