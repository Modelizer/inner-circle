FROM phpdockerio/php80-fpm:latest

MAINTAINER "Mohammed Mudassir <md@kubename.com>"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND="noninteractive"

WORKDIR /code

# Install locales package
RUN apt-get update && apt-get -y --no-install-recommends install git \
    php8.0-ds php8.0-redis php8.0-mysql php8.0-sqlite3 php8.0-intl php8.0-gmp \
    php8.0-gd php8.0-bcmath \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN usermod -u 1000 www-data && \
    chown -R www-data:www-data /code

CMD php-fpm8.0

EXPOSE 9000
