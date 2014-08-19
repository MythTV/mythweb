FROM ubuntu:14.10
MAINTAINER Rob Smith <kormoc@gmail.com>

RUN apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install apache2
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install libapache2-mod-php5
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php5-mysql
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php-apc
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php5-gd
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install php5-curl

RUN a2enmod rewrite
RUN a2enmod deflate
RUN a2enmod headers
RUN a2enmod auth_digest
RUN a2enmod cgi

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid

EXPOSE 80

RUN rm -rvf /var/www/html/*
ADD . /var/www/html
ADD mythweb.conf.apache /etc/apache2/sites-enabled/mythweb.conf

# Pull down bindings
ADD https://github.com/MythTV/mythtv/raw/master/mythtv/bindings/php/MythBackend.php         /var/www/html/classes/
ADD https://github.com/MythTV/mythtv/raw/master/mythtv/bindings/php/MythBase.php            /var/www/html/classes/
ADD https://github.com/MythTV/mythtv/raw/master/mythtv/bindings/php/MythFrontend.php        /var/www/html/classes/
ADD https://github.com/MythTV/mythtv/raw/master/mythtv/bindings/php/MythTV.php              /var/www/html/classes/
ADD https://github.com/MythTV/mythtv/raw/master/mythtv/bindings/php/MythTVChannel.php       /var/www/html/classes/
ADD https://github.com/MythTV/mythtv/raw/master/mythtv/bindings/php/MythTVProgram.php       /var/www/html/classes/
ADD https://github.com/MythTV/mythtv/raw/master/mythtv/bindings/php/MythTVRecording.php     /var/www/html/classes/
ADD https://github.com/MythTV/mythtv/raw/master/mythtv/bindings/php/MythTVStorageGroup.php  /var/www/html/classes/

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

CMD tail -F /var/log/apache2/*.log & /usr/sbin/apache2 -D FOREGROUND
