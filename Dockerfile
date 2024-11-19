# Use PHP with Apache as the base image
FROM php:8.2-apache

# Enable Apache modules
RUN a2enmod rewrite

# Install nvm and Node.js 18
ENV NVM_DIR /root/.nvm
RUN mkdir /root/.nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash \
    && . /root/.nvm/nvm.sh \
    && nvm install 18 \
    && nvm use 18 \
    && nvm alias default 18

# Install npm
RUN . /root/.nvm/nvm.sh && npm install -g npm@10.8.2

# Copy run.sh script into the container
COPY run.sh /usr/local/bin/run.sh

# Make run.sh executable
RUN chmod +x /usr/local/bin/run.sh

# Set the working directory
WORKDIR /var/www/html

# Copy the application code
COPY . /var/www/html

# Set DocumentRoot to Laravel public directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Add the rewrite configuration to Apache
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Enable Apache modules
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# CMD to run the run.sh script
CMD ["/usr/local/bin/run.sh"]
