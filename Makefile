chmod:
	sudo chmod 777 -R logs symfony

sh:
	docker-compose exec php sh

build-up:
	docker-compose up --build

composer-install:
	docker-compose exec php composer install

schema-init:
	docker-compose exec php bin/console doctrine:schema:update --force

migrate:
	docker-compose exec php bin/console doctrine:migration:migrate

newsletter:
	docker-compose exec php bin/console newsletter:send