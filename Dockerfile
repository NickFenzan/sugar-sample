FROM php:7.2-apache
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY www ./
RUN mkdir -p /data/upload && chmod 777 /data/upload
