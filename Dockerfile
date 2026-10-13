FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's/Listen 80/Listen 80/' /etc/apache2/ports.conf
WORKDIR /var/www/html
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
EXPOSE 80
CMD ["apache2-foreground"]
