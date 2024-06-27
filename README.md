Installation
Please check the official laravel installation guide for server requirements before you start. Official Documentation

1) Clone the repository
git clone https://github.com/parallaxlogicdevelopment/tenant.git

2) Switch to the repo folder
cd tenant/application

3) Install all the dependencies using composer
composer install

4) Copy the example env file and make the required configuration changes in the .env file
cp .env.example .env

5) Install Passport
Go to your project path in terminal and run below command for passport authentication.
composer require laravel/passport

6) Generate a new application key
php artisan key:generate

7) Run the database migrations (Set the database connection in .env before migrating)
php artisan migrate

8) Next, we need to install the Passport using command, and it will create token keys for security. let's run bellow command:
php artisan passport:install

9) Start the local development server
php artisan serve
You can now access the server at ...

TL;DR command list

git clone https://github.com/parallaxlogicdevelopment/tenant.git
cd tenant/application
composer install
cp .env.example .env
composer require laravel/passport
php artisan key:generate

Make sure you set the correct database connection information before running the migrations Environment variables
php artisan migrate
php artisan passport:install
php artisan serve