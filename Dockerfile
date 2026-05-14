FROM php:8.2-fpm

# Устанавливаем системные зависимости и PHP расширения (sockets нужен для RabbitMQ)
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev \
    && docker-php-ext-install sockets zip

WORKDIR /var/www/html

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Копируем зависимости
COPY composer.json ./
RUN composer install --no-interaction

# Копируем код
COPY ./www /var/www/html

CMD ["php-fpm"]