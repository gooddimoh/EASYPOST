init-build: docker-build init
init: drop down settings-os manager-init finish-containers install manager-jwt-token migrate manager-fixtures supervisor manager-clear-cache settings manager-assets-watch
prod-build: docker-build prod
prod: down settings-os manager-init finish-containers install manager-jwt-token migrate manager-assets-build-prod supervisor manager-clear-cache settings messenger-prod
dev-build: docker-build dev
dev: down settings-os manager-init finish-containers install migrate manager-fixtures manager-assets-build-dev supervisor manager-clear-cache settings
build: install manager-assets-build manager-clear-cache
docker-build:  manager-install-clear down manager-build
install: manager-composer-install manager-assets-install manager-assets-node-sass manager-clear-cache
watch-install: manager-assets-install watch
watch: manager-assets-watch
up: manager-init
down: docker-env manager-down
drop: manager-remove-data class 1 func1
bash: manager-bash
test-init: manager-test-all
test: manager-test-all
test-unit: manager-test-unit
migrate: manager-migrations
fixtures: manager-fixtures
fixtures-dev: manager-fixtures-dev
migrate-diff: manager-migrations-diff
messenger-restart: manager-stop manager-messenger
messenger-stop: manager-stop
messenger: manager-messenger
messenger-prod: manager-messenger-prod
nginx-reset: manager-clear-cache manager-nginx-restart
settings: manager-clear-cache app-init #settings-elastic
settings-os: settings-vm
finish-containers: #docker-finish
doc: manager-doc
eslint: manager-eslint
eslint-fix: manager-eslint-fix

docker-finish:
#	until  curl --silent --fail localhost:9200/_cluster/health | grep -q 'status' ; do sleep 1 ; done && echo "\e[92mElastic ready \e[0m"
settings-vm:
	#sudo sysctl -w vm.max_map_count=262144

settings-elastic:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "php bin/console fos:elastica:populate"

app-init:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "php bin/console app:init"

docker-env:
	cd laradock-master ; sudo rm -rf .env ; cp .env.example .env

manager-install-clear:
	sudo rm -rf vendor node_modules

manager-nginx-restart:
	cd laradock-master ; docker exec -t laradock_nginx_1 bash -c "nginx -t && nginx -s reload"

manager-build:
	cd laradock-master ; sudo docker system prune -a -f ; sudo docker-compose build --parallel --no-cache nginx postgres redis workspace php-fpm beanstalkd

manager-init:
	cd laradock-master ; sudo docker-compose up -d nginx postgres redis beanstalkd

manager-remove-data:
	if (([ ! -f .env.local ] &&  grep -q "APP_ENV=dev" .env;) || ([ -f .env.local ] && grep -q "APP_ENV=dev" .env.local;)) then (sudo rm -rf ~/.laradock && sudo rm -rf /root/.laradock && sudo rm -rf /root/laradock); else echo prod or data base not exists; fi
	cd laradock-master ; sudo docker-compose up -d postgres

manager-down:
	cd laradock-master ; sudo docker-compose down -v --remove-orphans

manager-bash:
	cd laradock-master ; sudo docker-compose exec --user=laradock workspace bash

manager-doc:
	cd laradock-master ; sudo docker-compose exec --user=laradock workspace bash -c "npm run build-doc"

manager-composer-install:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "composer install"

manager-clear-cache:
	cd laradock-master ; sleep 5 ; sudo docker-compose exec -T --user=laradock workspace bash -c "rm -rf var/cache"

manager-assets-install:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "yarn install"

manager-assets-node-sass:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "npm rebuild node-sass"

manager-assets-watch:
	cd laradock-master ; sudo docker-compose exec --user=laradock workspace script -q -c "npm run watch" /dev/null

manager-assets-build:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace script -q -c "npm run build" /dev/null

manager-eslint:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace script -q -c "npm run eslint" /dev/null

manager-eslint-fix:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace script -q -c "npm run eslint:fix" /dev/null

manager-assets-build-dev:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "composer dump-autoload --classmap-authoritative ; npm run prod"

manager-assets-build-prod:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "composer dump-autoload --no-dev --classmap-authoritative ; npm run prod"

manager-test-all:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "php bin/phpunit"

supervisor:
	#cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "supervisord"

manager-messenger:
	cd laradock-master ; sudo docker-compose exec --user=laradock workspace bash -c "php bin/console messenger:consume async -vv"

manager-messenger-prod:
	cd laradock-master ; sudo docker-compose exec -d --user=laradock workspace bash -c "php bin/console messenger:consume async"

manager-stop:
	cd laradock-master ; sudo docker-compose exec -d --user=laradock workspace bash -c "php bin/console  messenger:stop-workers"

manager-test-unit:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "php bin/phpunit --testsuite=unit"

manager-fixtures:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "php bin/console doctrine:fixtures:load --no-interaction"

manager-fixtures-dev:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "php bin/console doctrine:fixtures:load --no-interaction --group=dev"

manager-migrations:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "php bin/console doctrine:migrations:migrate --no-interaction"

manager-migrations-diff:
	cd laradock-master ; sudo docker-compose exec -T --user=laradock workspace bash -c "php bin/console doctrine:migrations:diff --no-interaction"

manager-jwt-token:
	cd laradock-master; \
	sudo docker-compose exec -T --user=laradock workspace bash -c "\
		mkdir -p config/jwt; \
		openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:1618a97a5c3c0fa67e947956ef843a8d; \
		openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout -passin pass:1618a97a5c3c0fa67e947956ef843a8d"
