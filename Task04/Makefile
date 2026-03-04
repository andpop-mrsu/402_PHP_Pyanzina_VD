install:
	cd laravel && composer install
	cd laravel && cp .env.example .env
	cd laravel && php artisan key:generate
	mkdir -p database
	touch database/database.sqlite
	cd laravel && php artisan migrate --force


start:
	cd laravel && php artisan serve