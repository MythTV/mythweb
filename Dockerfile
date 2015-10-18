################################################################################
# Mythweb Docker Container
# This container setups mythweb. This can run on any distribution and contains
# all the optional packages required to run mythweb.
#
# You'll likely want to run with --net=host to enable UPnP detection of the
# backends and database connections
################################################################################

FROM ubuntu:14.04
MAINTAINER Rob Smith <kormoc@gmail.com>

RUN apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install apache2 libapache2-mod-php5 php5-mysql php-apc php5-gd php5-curl

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

# Pull down bindings
ENV MYTHTV_BRANCH master
ENV MYTHTV_SCM_BASE https://raw.githubusercontent.com/MythTV/mythtv/${MYTHTV_BRANCH}
ADD ${MYTHTV_SCM_BASE}/mythtv/bindings/php/MythBackend.php           /var/www/html/classes/
ADD ${MYTHTV_SCM_BASE}/mythtv/bindings/php/MythBase.php              /var/www/html/classes/
ADD ${MYTHTV_SCM_BASE}/mythtv/bindings/php/MythFrontend.php          /var/www/html/classes/
ADD ${MYTHTV_SCM_BASE}/mythtv/bindings/php/MythTV.php                /var/www/html/classes/
ADD ${MYTHTV_SCM_BASE}/mythtv/bindings/php/MythTVChannel.php         /var/www/html/classes/
ADD ${MYTHTV_SCM_BASE}/mythtv/bindings/php/MythTVProgram.php         /var/www/html/classes/
ADD ${MYTHTV_SCM_BASE}/mythtv/bindings/php/MythTVRecording.php       /var/www/html/classes/
ADD ${MYTHTV_SCM_BASE}/mythtv/bindings/php/MythTVStorageGroup.php    /var/www/html/classes/

ADD mythweb.conf.apache /etc/apache2/sites-enabled/mythweb.conf
ADD . /var/www/html

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

CMD tail -F /var/log/apache2/*.log & /usr/sbin/apache2 -D FOREGROUND
