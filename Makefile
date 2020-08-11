SHELL='/bin/bash'

start:
	make stop
	@docker-compose up --build

stop:
	@docker-compose down

composer-install:
	make composer-run COMMAND="install"

composer-run:
	make php-composer-run COMMAND="composer ${COMMAND}"

php-composer-run:
	make php-composer-build
	docker run \
		--rm \
		--tty \
		--interactive \
		--workdir=/app \
		--user $(shell id -u):$(shell id -g) \
		--env COMPOSER_CACHE_DIR=/vendor-cache \
		--volume "$(PWD)/app":/app \
		--volume "$(PWD)/vendor-cache":/vendor-cache \
		php-composer ${COMMAND}

php-composer-build:
	docker build \
		--tag php-composer \
		devenv/php

composer-require:
	make composer-run COMMAND="require ${COMMAND}"

dump-autoload:
	make composer-run COMMAND="dump-autoload"

tests:
	make composer-run COMMAND="bin/phpunit"

php-build:
	docker build \
		--tag php \
		devenv/php

php-run:
	make php-build
	docker run \
		--rm \
		--tty \
		--interactive \
		--workdir=/app \
		--user $(shell id -u):$(shell id -g) \
		--volume "$(PWD)/app":/app \
		php ${COMMAND}

clear-cache:
	make php-run COMMAND="bin/console cache:clear --no-warmup --env=prod"
