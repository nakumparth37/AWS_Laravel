#!/bin/bash

# Set proxy environment variables (if needed)
# export HTTP_PROXY=http://10.10.0.12:9999
# export HTTPS_PROXY=http://10.10.0.12:9999

# echo 'Acquire::http::Proxy "http://10.10.0.12:9999";' >> /etc/apt/apt.conf.d/01proxy
# echo 'Acquire::https::Proxy "http://10.10.0.12:9999";' >> /etc/apt/apt.conf.d/01proxy


apt-get update && apt-get install -y \
    build-essential \
    git \
    ffmpeg \
    imagemagick \
    wget \
    nginx \
    curl \
    zip \
    unzip \
    gnupg \
    nano \
    openssh-server \
    php7.4-fpm \
    php7.4-dom \
    php7.4-imagick \
    php7.4-fileinfo \
    php7.4-iconv \
    php7.4-mbstring \
    php7.4-mysqli \
    php7.4-simplexml \
    php7.4-tokenizer \
    php7.4-xml \
    php7.4-curl \
    php7.4-zip \
    php7.4-intl \
    telnet

# Clear cache
apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Create a session directory
mkdir -p /var/www/html/storage/framework/sessions

# Set permissions for the session directory
chmod -R 777 /var/www/html/storage/framework/sessions

# Set session save path in php.ini (create custom .ini file)
echo "session.save_path = \"/var/www/html/storage/framework/sessions\"" > /usr/local/etc/php/conf.d/custom.ini

# Set working directory
cd /var/www/html

# Change ownership and permissions of all files and directories
chmod -R 777 /var/www/html

# Start Apache in the foreground
apache2-foreground
