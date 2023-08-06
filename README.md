## About

Simple TODO app.

This is a practice project, built as a VueJS warmup.

## Installation

Simplest way to get this up and running if you don't already have the right php/database dependencies is to just run it through Laravel Sail. Docker compose and php composer are needed for this.

Copy .env.example to .env

```
cp .env.example .env
```

Then

``` 
composer install
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm run dev
```

The site should now be accessible at http://localhost
