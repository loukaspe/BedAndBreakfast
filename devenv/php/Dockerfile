FROM php:7.3-fpm

RUN apt-get update -y
RUN apt-get install -y libssl-dev git zip

RUN pecl install mongodb
RUN docker-php-ext-enable mongodb

#RUN apt-get install -y librabbitmq-dev
#RUN pecl install amqp
#RUN docker-php-ext-enable amqp

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get install -y wget
COPY composer-install.sh .
RUN sh composer-install.sh
RUN rm composer-install.sh
