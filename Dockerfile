# Use an official PHP image with Apache
FROM php:8.2-apache

# Copy the website files to the container's web directory
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/ && chmod +x /var/www/html/draw.txt

# Expose port 80 for HTTP traffic
EXPOSE 80

