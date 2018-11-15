FROM rolandocaldas/php:7.2-dev-mysql

ENV APP_ENV=prod

COPY application /application
RUN php -d memory_limit=-1 /usr/local/bin/composer install --no-dev --optimize-autoloader
RUN php -d memory_limit=-1 /application/bin/console cache:clear --env=prod --no-debug

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
