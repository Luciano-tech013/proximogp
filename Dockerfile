FROM php:8.1-apache

COPY assets/ /var/www/html

COPY index.php /var/www/html

COPY src/ /var/www/src

EXPOSE 80

CMD ["apache2-foreground"]
