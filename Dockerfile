# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Fix: Disable conflicting MPMs, enable only mpm_event
RUN a2dismod mpm_event mpm_worker mpm_prefork 2>/dev/null; \
    a2enmod mpm_prefork

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy all your project files into the web server root
COPY . /var/www/html/

# Give proper permissions to files
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80
