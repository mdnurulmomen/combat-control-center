# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x/installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone https://github.com/mdnurulmomen/combat-control-center.git

Switch to the repo folder

    cd combat-control-center

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations 
(**Set the database connection & credentials mentioned in .env before migrating**)

    php artisan migrate

Generate a new JWT authentication secret key

    php artisan jwt:secret

Run the database seeder

    php artisan db:seed

## JWT Config

To work **asymmetric** token, we need both **public** & **private** keys. 
In order to generate those, we need a strong passphrase that should not be shared. In this test project I’ll use this (the following key is just for this demo purpose.

**_Note_:** Please change it for your system):

    sO9sH6qT8jA0wV5gE5eT3kY2

And I generated **public** and **private** keys with this passphrase key and already included at `storage/jwt`  directory. 

**_Note_:** Please, change the keys if you would work on enhancement. The command to generate an RSA private key of 4096 bits encrypted via AES256 into storage/jwt/private.pem is:

    openssl genrsa -passout pass:sO9sH6qT8jA0wV5gE5eT3kY2 -out storage/jwt/private.pem -aes256 4096


To generate the public key from our private key:

    openssl rsa -passin pass:sO9sH6qT8jA0wV5gE5eT3kY2 -pubout -in storage/jwt/private.pem -out storage/jwt/public.pem

Now we have public.pem and private.pem into our `storage/jwt` folder. We’ll add to the `.env` file our JWT configuration about the algorithm used and our keys :

    JWT_ALGO=RS256
    JWT_PUBLIC_KEY=jwt/public.pem
    JWT_PRIVATE_KEY=jwt/private.pem
    JWT_PASSPHRASE=sO9sH6qT8jA0wV5gE5eT3kY2

Please, make sure `config/jwt.php` file is updated to inform about the location of the private and public key:

    'public' => 'file://'.storage_path(env('JWT_PUBLIC_KEY')),
    
    'private' => 'file://'.storage_path(env('JWT_PRIVATE_KEY')),

Start the local development server and you're done

    php artisan serve

All set ! You can now access the server at http://localhost:8000

    
## Docker

To install with [Docker](https://www.docker.com), run following commands:

```
git clone https://github.com/mdnurulmomen/PetShop.git
cd PetShop
cp .env.example.docker .env
docker run -v $(pwd):/app composer install
cd ./docker
docker-compose up -d
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan jwt:secret
docker-compose exec php php artisan migrate
docker-compose exec php php artisan db:seed
docker-compose exec php php artisan serve --host=0.0.0.0
```

----------

# Code overview

## Dependencies

- [jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api/V1` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests/Api` - Contains all the api form requests
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeders` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests

## Environment variables

- `.env` - Environment variables can be set in this file

- `.env.testing` - Environment variables for testing can be set in this file

***Note*** : You can quickly set the database information and other variables in these files and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

Run the database migrations 
(**Set the database connection & credentials mentioned in .env.testing before migrating**)

    php artisan migrate --env=testing

The api can now be accessed at

    http://localhost:8000/api/v1

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| Accept         	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|
| Optional 	| Authorization    	| Token {JWT}      	|

Run the [Test Cases](https://laravel.com/docs/10.x/testing)

    php artisan test

----------
 
# Authentication
 
This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.
 
- https://jwt.io/introduction/

----------
