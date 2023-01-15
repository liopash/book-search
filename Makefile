help: ## Show help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install:  ## Install dependencies
	@echo Installing dependencies...
	@docker run --rm -it --volume $(PWD)/app:/app composer install --quiet

autoload:  ## Regenerate autoload (used after adding new classes)
	@docker run --rm -it --volume $(PWD)/app:/app composer dump-autoload

start: install ## Run application
	@echo Run application
	@docker-compose up -d

stop:  ## Stop application and delete containers and volumes
	@echo Stop application
	@docker-compose down

logs:  ## Show logs
	@echo Show docker logs
	@docker-compose logs

logs-app:  ## Show logs for app container
	@echo Show docker logs for app container
	@docker-compose logs app

tests: start ## Run tests
	@echo Run tests
	@docker exec app /app/vendor/bin/phpunit --testdox /app/tests
