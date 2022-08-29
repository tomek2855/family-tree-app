# Family Tree App

This app uses Laravel Sail to serve development environment (server, mysql, memcached).
If you have any problems with running the app go to [Laravel Sail Documentation](https://laravel.com/docs/9.x/sail).

## How to run
- clone this repo
- run command `composer install`
- run command `cp .env.example .env`
- run command `npm install`
- run command `npm run build`
- (on Windows) go to WSL via command `bash`
- run command `./vendor/bin/sail build`
- run command `./vendor/bin/sail up`
- run command `./vendor/bin/sail artisan key:generate`

### Requirements
- composer
- node/npm
- docker (it's also working with WSL on Windows)
