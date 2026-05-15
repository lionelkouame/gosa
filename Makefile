.PHONY: up down restart shell test test-unit test-integration lint fix stan coverage install

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
	docker compose exec app vendor/bin/phpunit --coverage-html var/coverage

lint:
	docker compose exec app vendor/bin/php-cs-fixer fix --dry-run --diff

fix:
	docker compose exec app vendor/bin/php-cs-fixer fix

stan:
	docker compose exec app vendor/bin/phpstan analyse

ci: lint stan test
