FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    libapache2-mod-php \
    php-mysql \
    php-curl \
    php-mbstring \
    && rm -rf /var/lib/apt/lists/*

# Enable rewrite module
RUN a2enmod rewrite

# Fix ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy project files
COPY . /var/www/html/
RUN rm -f /var/www/html/index.html
RUN chown -R www-data:www-data /var/www/html/

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# ✅ KEY FIX: Start script that sets Apache to listen on Railway's dynamic $PORT
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
