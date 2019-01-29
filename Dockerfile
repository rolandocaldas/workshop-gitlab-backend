FROM rolandocaldas/php:7.2-dev-mysql

ENV APP_ENV=prod

COPY application /application
COPY docker/php-fpm/docker-php-entrypoint /usr/local/bin/
COPY docker/php-fpm/php-ini-overrides.ini /usr/local/etc/php/conf.d/infrastructure-overrides.ini

RUN chmod ugo+x /usr/local/bin/docker-php-entrypoint

RUN cd /application && php -d memory_limit=-1 /usr/local/bin/composer install --no-dev --optimize-autoloader
RUN cd /application && php -d memory_limit=-1 /application/bin/console cache:clear --env=prod --no-debug


# This really helps for running the Symfony console with a docker exec
WORKDIR /application
