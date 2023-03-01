.SILENT: \
 help \
 init remake front-remake destroy deploy restart \
 start stop up down docker-ls \
 ps logs app nginx mysql du volume-ls volume-rm-volumes

.PHONY: help app logs nginx mysql

.DEFAULT_GOAL = help

## COLORS
COLOR_RESET     = \033[0m
COLOR_INFO      = \033[32m
COLOR_COMMENT   = \033[33m
COLOR_ERROR     = \033[0;31m
COLOR_COM       = \033[0;34m
COLOR_OBJ       = \033[0;36m

## VARIABLES
INIT_ENV 	    := .env
DOCKER_FILE     := -f docker-compose.yml
APP_VIA_DOCKER  := true
DOCKER_APP_EXEC :=
COMPOSER_FLAG   := --no-interaction --no-progress
MAKEFLAGS    	+= --no-print-directory # Forced blocking of directory printing

## REMOVE CURRENT ENV
ifneq (,$(findstring i, $(filter-out --no-print-directory, $(MAKEFLAGS))))
$(shell rm -f $(INIT_ENV))
$(shell printf "${COLOR_INFO}The current $(INIT_ENV) has been removed${COLOR_RESET}\n\n" 1>&2)
endif

## CHOOSE CURRENT ENV
ifeq (,$(wildcard $(INIT_ENV)))
$(shell printf "${COLOR_ERROR}The $(INIT_ENV) file is missing, create it first${COLOR_RESET}\n\n" 1>&2)
$(shell printf "${COLOR_INFO}Choose current env${COLOR_RESET}:\n" 1>&2)
$(shell printf "${COLOR_COMMENT}  - local${COLOR_RESET}${COLOR_COM} \t[1]${COLOR_RESET}\n" 1>&2)
$(shell printf "${COLOR_COMMENT}  - docker${COLOR_RESET}${COLOR_COM} \t[2]${COLOR_RESET}\n" 1>&2)

CRNT_ENV := $(shell bash -c 'read -p "" crnt_env; echo $$crnt_env')

ifeq (${CRNT_ENV}, 1)
	CRNT_ENV := .env.local
endif
ifeq (${CRNT_ENV}, 2)
	CRNT_ENV := .env.docker
endif

ifeq (,$(wildcard $(CRNT_ENV)))
$(error $(shell printf "${COLOR_ERROR}This $(CRNT_ENV) file is missing, create it first${COLOR_RESET}\n" 1>&2))

else
$(shell cp $(CRNT_ENV) $(INIT_ENV))
$(shell printf "${COLOR_INFO}The current $(INIT_ENV) has been updated to${COLOR_RESET}: ${COLOR_COM}$(CRNT_ENV)${COLOR_RESET}\n\n" 1>&2)
$(error $(shell printf "${COLOR_ERROR}Now you can use the make commands${COLOR_RESET}\n" 1>&2))
endif
endif

## IMPORT CURRENT ENV
include $(INIT_ENV)
export $(shell sed 's/=.*//' $(INIT_ENV))

## CHOOSE THE CORRECT DOCKER-COMPOSE FILE BASED ON APP_ENV
ifeq ($(APP_ENV), production)
	DOCKER_FILE := -f docker-compose-prod.yml
endif
ifeq ($(APP_ENV), local)
	DOCKER_FILE := -f docker-compose.override.yml
endif

## CHOOSE A SUITABLE SERVICE FOR CALLING PROGRAMS
ifeq ($(APP_VIA_DOCKER), true)
	DOCKER_APP_EXEC := docker-compose ${DOCKER_FILE} exec swd_app
	DOCKER_QUEUE_EXEC := docker-compose ${DOCKER_FILE} exec swd_queue
endif

## CHOOSE A SUITABLE APP USER
ifndef APP_USER
	APP_USER := $(USER)
	APP_USER := $(USER)
endif

ifeq ($(APP_ENV), production)
   COMPOSER_FLAG += --no-dev --optimize-autoloader
endif

# INFO
$(shell printf "${COLOR_INFO}  APP_ENV       ${COLOR_RESET} : \t${COLOR_COM}${APP_ENV}${COLOR_RESET}\n" 1>&2)
$(shell printf "${COLOR_INFO}  DOCKER_FILE   ${COLOR_RESET} : \t${COLOR_COM}" 1>&2) $(shell echo ${DOCKER_FILE} | cut -d ' ' -f 2 1>&2) $(shell printf "${COLOR_RESET}" 1>&2)
$(shell printf "${COLOR_INFO}  APP_VIA_DOCKER${COLOR_RESET} : \t${COLOR_COM}${APP_VIA_DOCKER}${COLOR_RESET}\n" 1>&2)
$(shell printf "${COLOR_INFO}  APP_USER      ${COLOR_RESET} : \t${COLOR_COM}${APP_USER}${COLOR_RESET}\n\n" 1>&2)

## HELP
help: ## This will output the help for each task
	printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	printf " make [options] [target]\n"
	printf "${COLOR_INFO}Options:${COLOR_RESET}\n"
	printf "  -i\t\t\t       This will delete the current $(INIT_ENV) file\n\n"
	printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z0-9\.@_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)


#############
# DEPLOYING #
#############
init: ## Initial build the container
ifeq ($(APP_VIA_DOCKER), true)
	docker-compose ${DOCKER_FILE} up --build -d
endif
	make composer-install
	make centrifugo-init
	make reinit-log
	$(DOCKER_APP_EXEC) php artisan key:generate
	$(DOCKER_APP_EXEC) php artisan storage:link
ifneq ($(APP_ENV), production)
	make fresh
endif
ifeq ($(APP_ENV), production)
	make migrate
endif
	make npm-install
	make swagger
ifeq ($(APP_ENV), production)
	make optimize
endif
	make salesforce-global-import
remake: ## Stop and remove a running containers and re-init them
	make destroy
	make init
soft-remake: ## Restart, refresh db and rebuild swagger docs
	make restart
	make fresh
ifneq ($(APP_ENV), production)
#	make swagger
endif
ifeq ($(APP_ENV), production)
	make optimize
endif
destroy: ## Stop and remove a running containers and volumes
	-$(DOCKER_APP_EXEC) rm -rf public/storage docker/volumes storage/logs/*.log
ifeq ($(APP_VIA_DOCKER), true)
	docker-compose ${DOCKER_FILE} down -v --rmi all
endif
destroy-all: ## Stop and remove a running containers and volumes and vendor node_modules folders
	-$(DOCKER_APP_EXEC) rm -rf vendor/ node_modules/
	make destroy
deploy: ## Git pull and cache warming and migrate
	git pull
	make composer-install
	make soft-remake

###################
# PROJECT COMMAND #
###################
larecipe: ## Recreate Larecipe Doc for each container
	$(DOCKER_APP_EXEC) php artisan larecipe:install
linter: ## Running all linters (php-cs-fixer, rector, psalm, phpunit) Services
	make du
	make php-cs-fixer
	make rector
	make psalm
	make phpunit
tinker: ## Running Tinker Services
	$(DOCKER_APP_EXEC) php artisan tinker
optimize: ## Warming all Laravel cache
	$(DOCKER_APP_EXEC) php artisan optimize
cache-clear: ## Clear all Laravel cache
	$(DOCKER_APP_EXEC) php artisan optimize:clear
migrate: ## Apply new migrations
	$(DOCKER_APP_EXEC) php artisan migrate --force
fresh: ## Refresh migrations and seeders for the Database
	$(DOCKER_APP_EXEC) php artisan migrate:fresh --seed
phpunit: ## Running phpunit tests
	-$(DOCKER_APP_EXEC) composer run phpunit
phpunit-parallel: ## Running phpunit-parallel tests
	-$(DOCKER_APP_EXEC) php artisan test --parallel --processes=4
failed: ## Running phpunit tests for certain group (mostly Docker)
	-$(DOCKER_APP_EXEC) php ./vendor/bin/phpunit --configuration phpunit.xml --group failing
php-cs-fixer: ## Fix code style with PHP-CS-Fixer tool
	-$(DOCKER_APP_EXEC) composer run php-cs-fixer
php-cs-fixer-check: ## Check code style with PHP-CS-Fixer tool
	-$(DOCKER_APP_EXEC) composer run php-cs-fixer-check
psalm: ## Check code style with Psalm tool
	-$(DOCKER_APP_EXEC) composer run psalm
rector: ## Check code style with Rector tool
	-$(DOCKER_APP_EXEC) composer run rector
swagger: ## To create a Swagger Docs (npm i, npm run prod, and swagger docs recreate)
	-$(DOCKER_APP_EXEC) php artisan apiato:swagger
readme: ## To create a file README
	-$(DOCKER_APP_EXEC) php artisan apiato:readme
composer-install: ## Run composer install
	-$(DOCKER_APP_EXEC) composer install $(COMPOSER_FLAG)
npm-install: ## Run npm install
	-$(DOCKER_APP_EXEC) npm install
local-queue: ## Run queue work
	php artisan queue:work --verbose --tries=3 --timeout=90
ide-helper:
	php artisan ide-helper:generate
	php artisan ide-helper:meta
#   php artisan ide-helper:models -W -r

###################
# DOCKER SERVICES #
###################
app: ## Execute a bash command in a running Php-Fpm
	$(DOCKER_APP_EXEC) bash
nginx: ## Execute a bash command in a running Nginx
	docker-compose ${DOCKER_FILE} exec swd_nginx bash
redis: ## Execute a bash command in a running Redis
	docker-compose ${DOCKER_FILE} exec swd_redis redis-cli
mysql: ## Execute a bash command in a running Mysql
	docker-compose ${DOCKER_FILE} exec swd_mysql bash


################
# DOCKER TASKS #
################
start: ## Start containers
ifeq ($(APP_VIA_DOCKER), true)
	docker-compose ${DOCKER_FILE} start
endif
stop: ## Stop a running containers
ifeq ($(APP_VIA_DOCKER), true)
	docker-compose ${DOCKER_FILE} stop
endif
up: ## Up containers
ifeq ($(APP_VIA_DOCKER), true)
	docker-compose ${DOCKER_FILE} up -d
endif
down: ## Down a running containers
ifeq ($(APP_VIA_DOCKER), true)
	docker-compose ${DOCKER_FILE} down
endif
restart: ## Restart the container
	make down
	make up
ps: ## List a running containers
	docker-compose ${DOCKER_FILE} ps
logs: ## View output logs from containers
ifeq ($(APP_VIA_DOCKER), true)
	docker-compose ${DOCKER_FILE} logs -f -t
endif
logs-to-file: ## Write output logs from containers to docker_logs.log file
	make logs > docker_logs.log
volume-ls: ## Check current docker volumes
	docker volume ls
volume-rm-volumes: ## Remove current docker volumes
	docker volume rm $(docker volume ls -q)
docker-ls: ## Show all docker images
	docker images -a
docker-rm-images: ## Remove all docker images
	docker rmi $(docker images -a -q)
xdebug-start: ## Only for docker
	$(DOCKER_APP_EXEC) sed -i "s/start_with_request=default/start_with_request=yes/" /etc/php/8.0/fpm/conf.d/30-xdebug.ini
	docker container restart swd_app
xdebug-stop: ## Only for docker
	$(DOCKER_APP_EXEC) sed -i "s/start_with_request=yes/start_with_request=default/" /etc/php/8.0/fpm/conf.d/30-xdebug.ini
	docker container restart swd_app


###########
# HELPERS #
###########
du: ## Update the composer autoloader
	-$(DOCKER_APP_EXEC) composer dump-autoload -o
reinit-log: ## Clean and Recreates all log files
	-$(DOCKER_APP_EXEC) rm -rf storage/logs/laravel.log storage/logs/debugger.log storage/debugbar/*.json
	-$(DOCKER_APP_EXEC) touch storage/logs/laravel.log
	-$(DOCKER_APP_EXEC) touch storage/logs/debugger.log
	-$(DOCKER_APP_EXEC) chown -R www-data storage
	-$(DOCKER_APP_EXEC) chown -R www-data bootstrap/cache
	-$(DOCKER_APP_EXEC) chmod -R 775 storage
	-$(DOCKER_APP_EXEC) chmod -R 775 bootstrap/cache
generate-self-signed-certs:
	openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout docker/nginx/letsencrypt/privkey.key -out docker/nginx/letsencrypt/fullchain.crt -config docker/nginx/localhost.conf
macos-add-cert-to-vault:
	sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ..docker/nginx/letsencrypt/fullchain.crt
macos-remove-cert-to-vault:
	sudo security delete-certificate -c fullchain.crt
windows-add-cert-to-store:
	certutil -addstore -f "ROOT" ..docker/nginx/letsencrypt/fullchain.crt
windows-remove-cert-to-store:
	certutil -delstore "ROOT" serial-number-hex
copy-local-swagger-to-ec2:
	make swagger
	scp -r -i ~/.ssh/swd-backend/swd-backend.pem ~/swd-backend/storage/app/documentation ubuntu@34.238.121.147/:~/swd-backend/storage/app
	scp -r -i ~/.ssh/swd-backend/swd-backend.pem ~/swd-backend/public/documentation ubuntu@34.238.121.147/:~/swd-backend/public
sentry-test:
	-$(DOCKER_APP_EXEC) php artisan sentry:test --transaction
salesforce-global-import:
	-$(DOCKER_APP_EXEC) php artisan salesforce:global:import
centrifugo-init:
	-$(DOCKER_APP_EXEC) php artisan laravel:centrifugo:init
	docker restart swd_centrifugo
queue-log:
	-$(DOCKER_QUEUE_EXEC) supervisorctl tail -f queue-$(queue)
queue-list:
	-$(DOCKER_QUEUE_EXEC) supervisorctl


