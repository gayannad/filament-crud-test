# Laravel Filament CRUD Assessment

This is a Laravel + Filament  project built as a technical assessment.


##  Features

-  Filament admin panel
-  Dashboard with model counts
-  CRUD for Products, Categories, Colors, Types
-  Polymorphic many-to-many (`type_assignment`) for types
-  Address validation using external API
-  Background job with logs , db notifications
-  Read-only `ViewProduct` page
-  Auto-type assignment based on selected category

---

## Requirements

- PHP 8.2+
- Laravel 12
- Node.js + NPM
- Composer
- MySQL or SQLite

---

## Setup Instructions

```bash
# 1. Clone the repo
git clone https://github.com/gayannad/filament-crud-test
cd filament-crud-test

# 2. Install dependencies
composer install
npm install

# 3. Copy and set environment
cp .env.example .env
php artisan key:generate

# 4. Configure DB in `.env`
DB_DATABASE=filament_crud
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations & seeders
php artisan migrate --seed

# 6. Compile frontend assets
npm run dev

# 7. Start local server
php artisan serve

# 8. Run Queue workers
php artisan queue:work
```

## Admin Access

### Local

- URL: http://localhost:8000/admin
- Email: test@example.com
- Password: password

### Cloud

- URL: https://filament-crud-test-main-u2zsoy.laravel.cloud/admin
- Email: test@example.com
- Password: password

