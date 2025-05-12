FROM php:8.1-apache

COPY index.php /var/www/html/index.php
COPY assets/   /var/www/html/assets/
COPY src/      /var/www/html/src/

EXPOSE 80
CMD ["apache2-foreground"]
