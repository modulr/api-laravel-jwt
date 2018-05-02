# Modulr API Laravel


## Table of Contents

- [Install](#install)
- [Routes](#routes)
  - [Authentication](authentication)


### Install

1. Clone repository
```
$ git clone https://github.com/modulr/api-laravel.git
```

2. Enter folder
```
$ cd api-laravel
```

3. Install composer dependencies
```
~/api-laravel$ composer install
```

4. Generate APP_KEY
```
~/api-laravel$ php artisan key:generate
```

5. Configure .env file
```
// Add database params
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

6. Run migrations
```
~/api-laravel$ php artisan migrate
```


### Routes

Authentication

- POST /auth/login
- GET /auth/logout
- POST /auth/signup
- GET /auth/user
