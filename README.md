<p align="center"><a href="https://laravel.com" target="_blank"></a> Create Payment Gateway With ACI,SHIFT4
<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



## Services
- Nginx
- Mysql(8.0.13)
- PHP(8.3)
- PhpMyAdmin
- Composer
- Redis
- Laravel 11

## Installation
```sh
- Install All Container Run These Command : 
  docker-compose up --build
  docker-compose up -d

- Down All Container Use this Command :
  docker-compose down
```

## Composer update or Install
```sh
docker-compose exec -it php bash
 composer i
 composer u
```

## Run Migration And Seed
```sh
docker-compose exec -it php bash
  php artisan migrate
  php artisan db:seed
```

## Run Artisan Command
```sh
docker-compose exec -it php bash
  php artisan fetch:article
  or
  php artisan schedule:run
  this command get data from third part api and store in database
```

## Run Project for test Api
```sh
like this : http://localhost:8082
this is my localhost in my system.
sample : http://localhost:8082/api/login
```

## Config Redis
```sh
This Project Use Redis For Caching and also handel queue with redis.
After All container up you can access redis-commander with this url :
 like this :http://localhost:8085
```

## Api Documentation
```sh
Use Swagger for Api Documentation:
http://localhost:8082/api/documentation
```

## Api Test
```sh
 php artisan test
```

## Demo Video Link
<a href="https://www.awesomescreenshot.com/video/30647872?key=c189c71bb38491fae896cdb92ef6397e">Please click to watch Demo</a>
