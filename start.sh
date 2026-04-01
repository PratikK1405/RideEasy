#!/bin/bash

# Railway gives us a PORT variable — Apache must listen on it
PORT=${PORT:-80}

echo "Starting Apache on port $PORT"

# Update Apache to listen on the dynamic port
sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/:80>/:$PORT>/" /etc/apache2/sites-enabled/000-default.conf

# Start Apache in foreground
apache2ctl -D FOREGROUND
