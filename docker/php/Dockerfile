FROM php:8.2.10-fpm

RUN apt-get update

RUN apt-get install -y libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql \
  && pecl install redis \
  && docker-php-ext-enable redis

RUN apt-get install -y supervisor

COPY docker/php/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

RUN touch /var/log/supervisor/supervisord.log

CMD ["/usr/bin/supervisord", "-n",  "-c", "/etc/supervisor/supervisord.conf"]
