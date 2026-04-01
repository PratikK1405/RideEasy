FROM ubuntu:22.04

# Prevent interactive prompts during install
ENV DEBIAN_FRONTEND=noninteractive

# Install Apache + PHP in one clean layer
RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    libapache2-mod-php \
    php-mysql \
    php-curl \
    php-mbstring \
    && rm -rf /var/lib/apt/lists/*

# Enable rewrite
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Remove default Apache page
RUN rm /var/www/html/index.html 2>/dev/null || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80

# Start Apache in foreground (required for Docker)
CMD ["apache2ctl", "-D", "FOREGROUND"]
