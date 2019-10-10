FROM php:7.3.10-cli

RUN apt-get update \
    && apt-get install -y \
    git zip libcurl4-openssl-dev libssl-dev pkg-config

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install the gmp
RUN apt-get update -y && \
    apt-get install -y libgmp-dev re2c libmhash-dev file && \
    ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/ && \
    docker-php-ext-configure gmp && \
    docker-php-ext-install gmp

COPY . /var/www/html/
WORKDIR /var/www/html
RUN composer install

# Use the official PHP 7.3 image.
# https://hub.docker.com/_/php
FROM php:7.3-apache


# Copy local code to the container image.
COPY . /var/www/html/
COPY --from=0 /var/www/html/vendor /var/www/html/vendor

# Use the PORT environment variable in Apache configuration files.
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configure PHP for development.
# Switch to the production php.ini for production operations.
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
# https://hub.docker.com/_/php#configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
