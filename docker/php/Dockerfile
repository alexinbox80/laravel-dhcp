FROM php:8.2.10-fpm

RUN apt-get update

RUN apt-get install -y libpq-dev unzip libaio1 libaio-dev curl \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql \
  && pecl install redis \
  && docker-php-ext-enable redis

RUN mkdir -p /opt/oracle

ADD docker/php/instantclient-basic-linux.x64-11.2.0.4.0.zip /opt/oracle
ADD docker/php/instantclient-sdk-linux.x64-11.2.0.4.0.zip /opt/oracle
ADD docker/php/instantclient-sqlplus-linux.x64-11.2.0.4.0.zip /opt/oracle

RUN cd /opt/oracle && unzip instantclient-basic-linux.x64-11.2.0.4.0.zip && rm instantclient-basic-linux.x64-11.2.0.4.0.zip
RUN cd /opt/oracle && unzip instantclient-sdk-linux.x64-11.2.0.4.0.zip && rm instantclient-sdk-linux.x64-11.2.0.4.0.zip
RUN cd /opt/oracle && unzip instantclient-sqlplus-linux.x64-11.2.0.4.0.zip && rm instantclient-sqlplus-linux.x64-11.2.0.4.0.zip

RUN cd /opt/oracle/instantclient_11_2 && ln -s /opt/oracle/instantclient_11_2/libclntsh.so.11.1 libclntsh.so
RUN cd /opt/oracle/instantclient_11_2 && ln -s /opt/oracle/instantclient_11_2/libocci.so.11.1 libocci.so

RUN echo /opt/oracle/instantclient_11_2 > /etc/ld.so.conf.d/oracle-instantclient.conf && ldconfig

ENV LD_LIBRARY_PATH /opt/oracle/instantclient_11_2

# Install Oracle extensions
#RUN docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/opt/oracle/instantclient_11_2 \
#&& echo 'instantclient,/opt/oracle/instantclient_11_2' | pecl install oci8 \
#&& docker-php-ext-install pdo_oci \
#&& docker-php-ext-enable oci8

#RUN docker-php-ext-configure oci8 --with-oci8=instantclient,/opt/oracle/instantclient_11_2 \
#&& echo 'shared,instantclient,/opt/oracle/instantclient_11_2' | pecl install oci8 \
#&& docker-php-ext-install pdo_oci \
#&& docker-php-ext-enable oci8

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        composer


RUN apt-get install -y supervisor

COPY docker/php/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

RUN touch /var/log/supervisor/supervisord.log

CMD ["/usr/bin/supervisord", "-n",  "-c", "/etc/supervisor/supervisord.conf"]
