FROM php:7.3-cli

RUN apt-get update -y
RUN apt-get install -y libssl-dev

RUN pecl install mongodb
RUN docker-php-ext-enable mongodb

#RUN apt-get install -y librabbitmq-dev
#RUN pecl install amqp
#RUN docker-php-ext-enable amqp
