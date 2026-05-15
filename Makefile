.PHONY: up down restart shell test test-unit test-integration lint fix stan coverage install docs behat

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose restart

shell:
	docker compose exec app sh

install:
	docker compose exec app composer install

test:
	docker compose exec app vendor/bin/phpunit

test-unit:
	docker compose exec app vendor/bin/phpunit --testsuite Unit

test-integration:
	docker compose exec app vendor/bin/phpunit --testsuite Integration

coverage:
	XDEBUG_MODE=coverage docker compose exec -e XDEBUG_MODE=coverage app vendor/bin/phpunit --coverage-html var/coverage/html --coverage-clover var/coverage/clover.xml

lint:
	docker compose exec app vendor/bin/php-cs-fixer fix --dry-run --diff

fix:
	docker compose exec app vendor/bin/php-cs-fixer fix

stan:
	docker compose exec app vendor/bin/phpstan analyse

behat:
	docker compose exec app vendor/bin/behat --no-interaction

ci: lint stan test behat

docs:
	docker compose --profile docs up docs
