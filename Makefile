
ENV_PATH=./.env
ifneq ("$(wildcard $(ENV_PATH))","")
	 include $(ENV_PATH)
endif

DOCKER_FILE=docker-compose.yml

#------ Setup
prepare-env:
	cp -n .env.example .env || true
	make key

setup:
	sudo chown -R $(USER):www-data storage
	sudo chown -R $(USER):www-data bootstrap/cache
	sudo chmod 775 -R storage/
	sudo chmod 775 -R bootstrap/cache/
	make c-mig

install:
	composer install
	npm i
	npm run build

#------ Helpers
key:
	php artisan key:generate


cnn=$(APP_NAME)_app # Container name
sn=app #Service name
app_container = $(APP_NAME)_app

#------ Docker
up:
	docker compose up -d
	docker exec $(app_container) service supervisor start

dw:
	docker compose down

in:
	docker exec -it $(cnn) bash

b:
	docker-compose --file $(DOCKER_FILE) build

bs:
	docker-compose --file $(DOCKER_FILE) build $(sn)

c=DatabaseSeeder
#------ DB
mig:
	php artisan migrate

migr:
	php artisan migrate:rollback

seed:
	php artisan db:seed --class=$(c)

migrf:
	php artisan migrate:refresh

c-mig:
	docker exec $(APP_NAME)_app make mig

c-migr:
	docker exec $(APP_NAME)_app make migr

c-seed:
	docker exec $(APP_NAME)_app make seed c=$(c)

c-migrf:
	docker exec $(APP_NAME)_app make migrf



