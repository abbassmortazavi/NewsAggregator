<p align="center"><a href="https://laravel.com" target="_blank"></a> Create News Aggregator API




## Services
- Nginx
- Docker
- Mysql(8.0.13)
- PHP(8.3)
- PhpMyAdmin
- Composer
- Redis
- Laravel 11


## Clone Project
```sh
- First of All Clone Project From bottom url : 
  https://github.com/abbassmortazavi/NewsAggregator.git
After clone, in root project in command line run this command before migrate : 
  cp .env.example .env
```



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
  this command get data from third-party api and store or update in database
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
 like this: http://localhost:8085
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
