start:
	./vendor/bin/sail up

stop:
	./vendor/bin/sail down

migrate:
	./vendor/bin/sail artisan migrate

test:
	docker exec -t api-morbibike-laravel.test-1 ./vendor/bin/pest
