FROM phpswoole/swoole:latest

RUN docker-php-ext-install mysqli pdo_mysql
