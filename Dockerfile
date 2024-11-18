FROM php:8.3.13-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    netcat-openbsd \
    && docker-php-ext-install pdo pdo_mysql sockets zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install

COPY init.sh /app/init.sh

RUN chmod +x /app/init.sh

COPY .env.example /app/.env

RUN chmod 644 /app/.env

