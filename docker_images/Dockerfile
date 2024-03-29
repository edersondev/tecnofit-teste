FROM php:8.1-apache-buster
LABEL maintainer="Ederson Ferreira <ederson.dev@gmail.com>"

ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && apt-get install -y --no-install-recommends \
  unzip \
  zip \
  curl \
  nano \
  locales \
  libonig-dev \
  zlib1g-dev \
  libpng-dev \
  libcurl4-openssl-dev \
  sqlite3 \
  libsqlite3-dev

RUN localedef -i pt_BR -c -f UTF-8 -A /usr/share/locale/locale.alias pt_BR.UTF-8

ENV LANG pt_BR.UTF-8
ENV LC_ALL pt_BR.UTF-8

RUN docker-php-ext-install bcmath mbstring gd curl opcache mysqli pdo_mysql pdo_sqlite

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN a2enmod rewrite

ENV APACHE_LOG_DIR="/var/log/apache2"

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

COPY docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]

# Install composer
WORKDIR /usr/local/bin/
RUN curl -sS https://getcomposer.org/installer | php
RUN chmod +x composer.phar
RUN mv composer.phar composer

# Set path bin
WORKDIR /root
RUN echo 'export PATH="$PATH:$HOME/.composer/vendor/bin"' >> ~/.bashrc

# Configuração Xdebug
RUN { \
    echo 'xdebug.client_host=host.docker.internal'; \
    echo 'xdebug.idekey=VSCODE'; \
    echo 'xdebug.mode=develop,debug,coverage'; \
} >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Clean
RUN apt-get clean && apt-get autoclean && apt-get autoremove -y \
&& rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

CMD ["apache2-foreground"]
