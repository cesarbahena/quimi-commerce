.PHONY: help install deps test lint static-analysis phpstan psalm cs-fixer db-start db-stop db-reset logs

help:
	@echo "Quimi Commerce - Development Commands"
	@echo ""
	@echo "  make install       - Install dependencies"
	@echo "  make deps          - Install PHP dependencies"
	@echo "  make test          - Run all tests"
	@echo "  make test-unit     - Run unit tests only"
	@echo "  make test-integration - Run integration tests only"
	@echo "  make lint          - Run linting"
	@echo "  make static-analysis - Run static analysis"
	@echo "  make phpstan       - Run PHPStan"
	@echo "  make psalm         - Run Psalm"
	@echo "  make cs-fixer      - Run PHP CS Fixer"
	@echo "  make db-start      - Start database containers"
	@echo "  make db-stop       - Stop database containers"
	@echo "  make db-reset      - Reset database"
	@echo "  make logs          - View container logs"
	@echo "  make docker-up     - Start all services"
	@echo "  make docker-down   - Stop all services"

install:
	cd backend && composer install

deps:
	cd backend && composer install --prefer-dist --no-interaction

test:
	cd backend && vendor/bin/phpunit

test-unit:
	cd backend && vendor/bin/phpunit --testsuite=unit

test-integration:
	cd backend && vendor/bin/phpunit --testsuite=integration

lint:
	cd backend && vendor/bin/php-cs-fixer fix --diff

static-analysis: phpstan psalm

phpstan:
	cd backend && vendor/bin/phpstan analyse

psalm:
	cd backend && vendor/bin/psalm

cs-fixer:
	cd backend && vendor/bin/php-cs-fixer fix --diff

db-start:
	docker compose -f docker-compose.database.yml up -d

db-stop:
	docker compose -f docker-compose.database.yml down

db-reset:
	docker compose -f docker-compose.database.yml down -v

docker-up:
	docker compose up -d

docker-down:
	docker compose down

logs:
	docker compose logs -f
