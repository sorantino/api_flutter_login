FROM php:8.3-apache
RUN a2enmod rewrite && sed -i "s/AllowOverride None/AllowOverride All/" /etc/apache2/apache2.conf
COPY src/ /var/www/html/
