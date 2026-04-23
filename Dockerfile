FROM composer:lts AS build

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --no-interaction --no-autoloader

COPY . .

# RUN composer dump-autoload --optimize

FROM node:24-alpine AS node_builder

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install --legacy-peer-deps

COPY --from=build --chown=www-data:www-data /app /app

COPY ./devops/Docker/live/env/.env.frontend /app/.env

RUN npm run build && \
    rm -rf resources/js \
    node_modules \
    package.json \
    package-lock.json

RUN rm -f .env

FROM alpine:latest AS beanstalkd

RUN apk update && apk add beanstalkd

EXPOSE 11300

CMD /usr/bin/beanstalkd -V

FROM php:8.4-fpm-alpine AS php_fpm

ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_REVALIDATE_FREQ=0

WORKDIR /var/www/html

RUN apk add --no-cache \
  # libzip-dev freetype-dev libjpeg-turbo-dev libpng-dev libwebp-dev \
  $PHPIZE_DEPS \
  icu-dev \
  libzip-dev \ 
  zip \
  # && docker-php-ext-configure gd --with-jpeg \
  && docker-php-ext-configure opcache --enable-opcache \
  && docker-php-ext-install -j$(nproc) \
  pdo \ 
  zip \
  intl \
  pdo_mysql \
  bcmath \
  # For Que Workers,, process Process Control extension
  pcntl \
  && pecl install redis \
  && docker-php-ext-enable redis intl\
  && apk del $PHPIZE_DEPS \
  && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*


COPY ./devops/Docker/live/php/php.ini /usr/local/etc/php/php.ini
COPY ./devops/Docker/live/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./devops/Docker/live/php/start-container /usr/local/bin/start-container


RUN chmod +x /usr/local/bin/start-container

USER www-data

COPY --from=node_builder --chown=www-data:www-data /app /var/www/html

RUN mkdir -p storage/framework/sessions \
  storage/framework/views \
  storage/framework/cache \
  storage/logs \
  storage/app/public

ENTRYPOINT ["/usr/local/bin/start-container"]

FROM nginx:alpine AS nginx_server

RUN adduser -D -G www-data www-data

WORKDIR /var/www/html

COPY ./devops/Docker/live/nginx/nginx.conf /etc/nginx/nginx.conf.template
COPY ./devops/Docker/live/nginx/entrypoint.sh /entrypoint.sh
COPY ./devops/Docker/live/nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy Laravel public directory (index.php, etc.)
COPY --from=build /app/public /var/www/html/public

COPY --from=node_builder /app/public/build /var/www/html/public/build

RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
