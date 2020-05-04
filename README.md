# Timesheet

## How to start
* Clone project
* Run `composer install`
* Run `cp .env-example .env` then fill out the database information
* Run `php artisan key:generate` to create app key
* Run `php artisan migrate --seed` to create tables
* Run `php artisan passport:install` to install passport dependencies
* (Optional) Run `php artisan db:seed --class=CreateDefaultOAuthClienSeeder` to create default client ID and client secret
* Update client ID and secret to `.env`
* Run `npm install` then `npm run prod`
* Go to browser and see the application
