# Static            ————————————————————————————————————————————————————————————————————————————————————————————————————
LC_LANG				= it_IT
DEFAULT_GOAL 		:= help
SHELL 				= /bin/bash
PROJECT_NAME        = $(shell basename $(shell pwd) | tr '[:upper:]' '[:lower:]')
PHP_STAGED_FILES	= $(shell git diff --name-only --cached --diff-filter=ACMR -- '*.php' | sed 's| |\\ |g')
# Setup             ————————————————————————————————————————————————————————————————————————————————————————————————————
php_container		:= php
node_container		:= nodejs
docker_compose_exec := docker-compose
compose				:= $(docker_compose_exec) --file .docker/docker-compose.yml --file .docker/docker-compose.override.yml
# End configuration ————————————————————————————————————————————————————————————————————————————————————————————————————

.PHONY: start
start: ## avvia tutti i servizi
		$(compose) -p $(PROJECT_NAME) start

.PHONY: stop
stop: ## ferma l'ambiente di sviluppo
		$(compose) -p $(PROJECT_NAME) stop $(s)

.PHONY: up
up: ## tira su l'ambiente di sviluppo
		$(compose) -p $(PROJECT_NAME) up -d --remove-orphans

.PHONY: rebuild
rebuild: ## esegue un rebuild del sistema
		$(compose) -p $(PROJECT_NAME) up -d --build

.PHONY: erase
erase: ## ferma ed elimina i containers ed i loro volume
		$(compose) -p $(PROJECT_NAME) down -v

.PHONY: prepare
prepare: hooks ## esegue la preparazione dell'ambiente
		test -s .docker/php/ssh || mkdir -p .docker/php/ssh
		test -s .docker/php/ssh/id_rsa || cp ~/.ssh/id_rsa .docker/php/ssh/
		test -s .docker/php/ssh/id_rsa.pub || cp ~/.ssh/id_rsa.pub .docker/php/ssh/

.PHONY: hooks
hooks: ## aggiunge gli hooks di Git
		test -s .git/hooks && rm -rf .git/hooks && ln -s ../../.docker/scripts/git-hooks .git/hooks

.PHONY: build
build: prepare ## esegue un build del sistema
		$(compose) -p $(PROJECT_NAME) build

.PHONY: composer-update
composer-update: xoff ## aggiorna le dipendenze del progetto
		$(compose) -p $(PROJECT_NAME) run --rm $(php_container) sh -lc 'COMPOSER_MEMORY_LIMIT=-1 composer update'

.PHONY: composer-install
composer-install: xoff ## installa le dipendenze del progetto
		$(compose) -p $(PROJECT_NAME) run --rm $(php_container) sh -lc 'COMPOSER_MEMORY_LIMIT=-1 composer install'

.PHONY: phpunit
phpunit: ## esegue phpunit
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc "sudo xoff;php vendor/bin/phpunit"

.PHONY: test
test: phpunit ## esegue i test unitari e di integrazione

.PHONY: check-cs-fix
check-cs-fix: ## verifica i coding standards
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc "php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php $(PHP_STAGED_FILES) --show-progress=dots --dry-run"

.PHONY: cs-fix
cs-fix: ## esegue e fixa i coding standards
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc "sudo xoff;php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php"

.PHONY: coverage
coverage: ## esegue il coverage
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc "sudo xon;XDEBUG_MODE=coverage php bin/phpunit --coverage-html public/coverage --coverage-clover public/coverage-clover.xml && vendor/bin/php-coverage-badger public/coverage-clover.xml public/coverage-badge.svg;sudo xoff"

.PHONY: xon
xon: ## Avvia Xdebug
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc "sudo xon"

.PHONY: xoff
xoff: ## Ferma Xdebug
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc "sudo xoff"

.PHONY: phpstan
phpstan: ## esegue phpstan
		$(compose) -p $(PROJECT_NAME) exec -T $(php_container) sh -lc 'sudo xoff;php ./vendor/bin/phpstan analyse src'

.PHONY: enter
enter: ## entra in ambiente ZSH
		$(compose) -p $(PROJECT_NAME) exec -u utente $(php_container) //bin//zsh

.PHONY: root
root: ## entra in ambiente ZSH come root
		$(compose) -p $(PROJECT_NAME) exec -u root $(php_container) //bin//zsh

.PHONY: commitlint
commitlint: ## verifica la corretta stesura del commit
		$(compose) -p $(PROJECT_NAME) run $(node_container) sh -lc 'commitlint -e --from=HEAD'

.PHONY: help
help: ## Mostra questo messaggio
		@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
