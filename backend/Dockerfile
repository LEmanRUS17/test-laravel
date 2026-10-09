FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Сначала ставим зависимости, чтобы Docker кешировал этот слой, пока не меняется composer.lock
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --prefer-dist

COPY . .
RUN composer dump-autoload --optimize --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
