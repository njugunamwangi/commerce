## About Project

A simple e-commerce assignment

## Tech Stack

- [Laravel](https://laravel.com).
- [Livewire](https://livewire.laravel.com).
- [TailwindCSS](https://tailwindcss.com).
- [FilamentPHP V3](https://filamentphp.com).

## Installation guide

- Clone the repository

```bash
git clone https://github.com/njugunamwangi/commerce.git
```
- On the root of the directory, copy and paste .env.example onto .env and configure the database accordingly
 ```bash
copy .env.example .env
```

- Run migrations and seed the database
```bash
php artisan migrate --seed
```

- Install composer dependencies by running composer install
 ```bash
composer install
```

- Install npm dependencies
```bash
npm install
```

- Generate laravel application key using 
```bash
php artisan key:generate
```

- Don't forget to run the application
```bash
npm run dev
```

- Run the application
```bash
php artisan serve
```


## Routes

- [Admin Panel](https://localhost:8080/admin).

## Prerequisites

- Admin panel credentials

```bash
email: info@ndachi.dev
password: password
```

## API endpoints

- Authentication

```bash
http://localhost:8080/v1/auth/login
```

```bash
http://localhost:8080/v1/auth/register
```

- Products

```bash
http://localhost:8080/v1/products
```

```bash
http://localhost:8080/v1/products/{id}
```

- Cart

```bash
http://localhost:8080/v1/cart
```

- Orders

```bash
http://localhost:8080/v1/orders
```
