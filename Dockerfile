# Use official PHP with Apache web server
FROM php:8.2-apache

# Copy all your project files into the server folder
COPY . /var/www/html/

# Enable Apache rewrite module (needed for most PHP apps)
RUN a2enmod rewrite

# Open port 80 for web traffic
EXPOSE 80
