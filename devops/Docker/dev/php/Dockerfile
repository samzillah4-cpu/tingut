#========================================================================
# DOCKERFILE FOR PHP-FPM LARAVEL DEVELOPMENT ENVIRONMENT (ALPINE BASE)
#========================================================================
# Base Image: php:8.4-fpm-alpine
# - Provides PHP 8.4 with PHP-FPM (FastCGI Process Manager).
# - Uses Alpine Linux (lightweight, ~5 MB) instead of Debian.
# - Smaller but requires more explicit package installation.
# Target Use: Development (can adapt for Production)
#========================================================================
FROM php:8.4-fpm-alpine AS php

ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_REVALIDATE_FREQ=0

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG USERNAME=kainga

# Set working directory to Laravel application root
WORKDIR /var/www/html

RUN apk add --no-cache \
  linux-headers icu-dev git libzip-dev zip $PHPIZE_DEPS \
  && docker-php-ext-install -j$(nproc) zip pdo pdo_mysql intl pcntl bcmath \
  && pecl install redis \
  && docker-php-ext-enable redis intl \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && docker-php-ext-configure opcache --enable-opcache \
  && curl -o /usr/local/bin/php-fpm-healthcheck https://raw.githubusercontent.com/renatomefi/php-fpm-healthcheck/master/php-fpm-healthcheck \
  && chmod +x /usr/local/bin/php-fpm-healthcheck \
  && apk del $PHPIZE_DEPS linux-headers \
  && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*


COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

RUN addgroup -g ${GROUP_ID} ${USERNAME} \
  && adduser -D -u ${USER_ID} -G ${USERNAME} -s /bin/bash ${USERNAME} \
  && addgroup ${USERNAME} wheel \
  && echo "${USERNAME} ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers


# Run everything as non-root user
USER ${USERNAME}

ENTRYPOINT ["/usr/local/bin/start-container"]
