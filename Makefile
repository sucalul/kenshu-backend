build:
	docker-compose build

up:
	@make build
	docker-compose up

exec:
	docker-compose exec web bash

exec-db:
	docker-compose exec db bash -c "psql -U postgres"

ps:
	docker-compose ps

stop:
	docker-compose stop

down:
	docker-compose down

rm-db:
	docker-compose stop \
	&& docker-compose down \
	&& docker volume rm kenshu-backend_postgres \
	&& docker-compose up
