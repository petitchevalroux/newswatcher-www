FROM maxexcloo/nginx-php:latest
MAINTAINER Patrick Poulain <petitchevalroux@free.fr>
RUN mkdir -p /data/http/public && \
perl -pi -e 's~root /data/http~root /data/http/public~g' /etc/nginx/host.d/default.conf
ADD . /data/http
ADD ./docker/nginx/default-host.conf /etc/nginx/host.d/default.conf
RUN apt-get update && \
    apt-get install -y libtool pkg-config php-pear php5-dev && \
    apt-get clean
RUN cd /tmp && \
    git clone -b v0.5.2 git://github.com/alanxz/rabbitmq-c.git && \
    cd rabbitmq-c && \
    autoreconf -i && ./configure && make && make install && \
    pecl install amqp-1.4.0 && \
    echo "extension=amqp.so" > /etc/php5/mods-available/amqp.ini && \
    cd /etc/php5/cli/conf.d/ && \
    ln -s ../../mods-available/amqp.ini 20-amqp.ini && \
    cd /etc/php5/fpm/conf.d/ && \
    ln -s ../../mods-available/amqp.ini 20-amqp.ini
