## APP Setup

1. Setup MYSQL, PHP, Composer
    * MYSQL 8
    * PHP 7.4
    * Composer 2
1. Create `.env` on `root` folder check `.env.example` for reference
1. Setup DATABASE Configuration on `.env` located on root folder
1. Go to root directory and run the ff:
    * `composer install`
    * `php artisan migrate`
1. to run API - `php artisan serve`
1. Make sure to have the right permissions specially on the API when running it via `php artisan serve` or NGINX
1. I have also attached my Postman Collection as a JSON file in the `root` folder for your reference on how to use the API

If you have more questions kindly email me @ ziegfrid.gualberto@gmail.com