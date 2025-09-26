<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Installation

Follow these steps to run this project locally:

### Prerequisites

- PHP >= v8.2
- Composer
- Node.js >= v18.0
- MySQL

### Installation steps

1. Clone the repo

```bash
git clone https://github.com/januarpancaran/property-rental.git
cd property-rental
```

2. Install dependencies

```bash
composer install
npm install
```

3. Setup env

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=property_db
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations

```bash
php artisan migrate:fresh --seed
```

6. Start development server

```bash
npm run dev
php artisan serve

# Or run both at the same time
npx concurrently "npm run dev" "php artisan serve"
```

Your app should be running at `https://localhost:8000`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
