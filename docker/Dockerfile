FROM php:8.2-apache-bookworm

# Actualización de paquetes y herramientas necesarias
RUN apt-get update -y \
    && apt-get install -y --no-install-recommends \
       build-essential \
       vim wget \
       dialog \
       git \
       libxml2-dev \
       libicu-dev \
       zlib1g-dev \
       zip unzip \
       g++ \
       libpng-dev \
       libjpeg-dev \
       libfreetype6-dev \
       libcurl4 \
       libcurl4-openssl-dev \
       openssl \
       ssl-cert \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones básicas de PHP usando las herramientas nativas de docker-php
RUN docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd dom fileinfo filter pdo pdo_mysql ctype intl \
    && docker-php-ext-enable ctype intl

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Instalar extensiones adicionales usando mlocati/docker-php-extension-installer
RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o install-php-extensions \
    && chmod +x install-php-extensions \
    && ./install-php-extensions mbstring xdebug bcmath soap gettext opcache simplexml mysqli iconv hash json

# Configuración de Apache
RUN a2enmod ssl rewrite headers

# Copiar configuraciones personalizadas
COPY ./config/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./config/ssl/cert.pem /etc/apache2/ssl/cert.pem
COPY ./config/ssl/key.pem /etc/apache2/ssl/key.pem
COPY ./config/apache/default.conf /etc/apache2/sites-enabled/000-default.conf

# Limpiar y preparar permisos
RUN apt-get autoremove -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && usermod -u 1000 www-data \
    && chown -R www-data:www-data /var/www/html

# Exponer puertos
EXPOSE 80
EXPOSE 443