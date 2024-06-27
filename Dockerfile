# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y openssl zip unzip git curl libzip-dev libonig-dev libicu-dev autoconf pkg-config libssl-dev && \
    docker-php-ext-install pdo pdo_mysql mysqli bcmath mbstring intl opcache && \
    pecl install mongodb && \
    echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

# Copy existing application directory contents
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
RUN composer install

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php", "artisan", "serve","--host=0.0.0.0","--port=9000"]
