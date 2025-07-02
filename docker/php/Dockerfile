FROM php:8.3-fpm-bullseye
EXPOSE 5173

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
	git \
	curl \
	zip \
	unzip \
  && docker-php-ext-install pdo_mysql \
	opcache \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug

  #nodejsを入れる
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash -
RUN apt-get install -y nodejs

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY . /var/www/html

WORKDIR /var/www/html
RUN composer install