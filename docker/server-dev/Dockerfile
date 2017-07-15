FROM hub.c.163.com/library/php:7.1.7-apache
RUN pecl install xdebug-2.5.5 \\
    && docker-php-ext-enable xdebug
ADD docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/
