# countries

## Dependencies
 * PHP 7.3.9 -- WARNING 7.3.0 will prevent db compatibility 
 * MySQL tested with verison 5.6.27
 * Composer ^1.8.0
 * NPM - ^6.4.1

## Installation Instructions 
 1. Pull Repo 
 2. `composer install`
 3. `npm install`
 4. `npm run prod`
 5. `php artisan db:create`
 6. `php artisan migrate`
 7. `php artisan serve`
 8. In a browser go to http://127.0.0.1:8000

![](demo.gif)
