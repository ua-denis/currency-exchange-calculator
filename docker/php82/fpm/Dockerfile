FROM php:8.2-fpm-bullseye
LABEL version="1.0"
LABEL maintainer="Denys"

RUN apt-get update && apt-get install -y \
    git \
    curl \
    cron \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    libmemcached-dev \
    unzip \
    apt-utils \
    procps \
    vim \
    default-mysql-client \
    inetutils-ping

RUN docker-php-ext-install bcmath mbstring pdo pdo_mysql soap zip gd exif pcntl opcache

RUN pecl install igbinary apcu \
    && docker-php-ext-enable igbinary apcu

ENV MEMCACHED_VERSION="3.2.0"
RUN pecl download memcached-$MEMCACHED_VERSION \
    && tar xzvf memcached-$MEMCACHED_VERSION.tgz \
    && cd memcached-$MEMCACHED_VERSION \
    && phpize \
    && ./configure --enable-memcached-igbinary --disable-memcached-sasl \
    && make \
    && make install \
    && docker-php-ext-enable memcached


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/backend-commission-calculator-app

# Copy the rest of the application code
COPY . .

###########################################################################
# Composer:
###########################################################################

# Use root user for installations
USER root

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Initialize a new Composer project if composer.json doesn't exist
RUN if [ ! -f "composer.json" ]; then \
        composer init --no-interaction \
        --name "vendor/resume-statistic-app" \
        --type "project" \
        --license "proprietary"; \
    fi

# Update and install dependencies
RUN composer update --no-scripts
RUN composer install --no-scripts

# Copy PHP configuration
COPY docker/php82/php82.ini /usr/local/etc/php/conf.d/

#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Configure non-root user.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}
#
RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM directly
CMD ["php-fpm"]