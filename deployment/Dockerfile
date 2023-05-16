# Set the base image to PHP 8.1
FROM php:8.1


# Install required packages
RUN apt-get update -qq -y && apt-get install -qq -y \
    git \
    libzip-dev \
    zip \
    unzip \
    libpng-dev

# Install PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    zip \
    pcntl \
    gd \
    sockets \
    http

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# Copy the application code to the container
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install the application dependencies
RUN composer install

# Expose the default Laravel port
EXPOSE 80

# Start the application
CMD php artisan octane:start --host=0.0.0.0 --port=80