cat > Dockerfile << 'EOF'
FROM php:8.2-apache

# Enable mysqli and pdo_mysql for your config/database connection
RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite

WORKDIR /var/www/html

# Copy all your project files
COPY . /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Apache runs on port 80
EXPOSE 80

CMD ["apache2-foreground"]
EOF