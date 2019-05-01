
  
# Setup: Laravel + Lighthouse + Passport

This repository is just a setup and initial configurations to make Laravel works out of the box with GraphQL with Lighthouse and secured by Laravel Passport.

## Read more:
* [Laravel](https://laravel.com/docs/5.8) 
* [Lighthouse](https://lighthouse-php.com/3.3/getting-started/installation.html)
* [Passport](https://laravel.com/docs/5.8/passport)

## Install:
Clone this repo and enter directory:
	
    git clone https://github.com/estudiogenius/laravel-lighthouse-passport.git
    cd laravel-lighthouse-passport

Install composer dependencies and copy .env file from example:

    composer install
    cp .env.example .env

Generate a random APP_KEY in the **.env** file with:

    php artisan key:generate --ansi

Also dont forget to set your database in the **.env** file:

    DB_CONNECTION=mysql  
    DB_HOST=127.0.0.1  
    DB_PORT=3306  
    DB_DATABASE= . . .  
    DB_USERNAME= . . .  
    DB_PASSWORD= . . .
	
	#or if you want something faster
	touch database.sqlite
	DB_CONNECTION=sqlite
	DB_DATABASE=database.sqlite

Finally... run migration and generate passport keys:

    php artisan migrate
    php artisan passport:install

## Rise the GraphQL server:

After installation completed, you can just serve the GraphQL server with:

    php artisan serve

- Regular routes will be at: **http://127.0.0.1:8000/**
- GraphQL server will be at **http://127.0.0.1:8000/graphql**
- GraphQL playground will be at **http://127.0.0.1:8000/graphql-playground** 

## TODO:

* List of TODOs (yes, I know!)
* ...