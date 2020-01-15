
Deployment Documentation

Hello!

Welcome to my ZeroWasteFoods project.

The project was uploaded on a server and base urls were created for each of the parts:

The admin application:
http://admin.stefan.zerofood.cz/  stefan@stefan.com pw: 123

The user application:
http://order.stefan.zerofood.cz/  s@s.gmail.com pw: s

The backend:
http://stefan.zerofood.cz/ 

And they all have been redirected to the teeside server on: https://w9308612.scedt.tees.ac.uk/

For local host:

To run the project please install composer and yarn and/or npm.

First open the backend, laravel, file and type

cp .env.example .env

once the env is set up run:
composer install
It will install all the dependencies.

php artisan key:generate

php artisan migrate

php artisan passport:install

and with that the back end code itself is ready, if run on localhost I use:

php artisan serve

#Frontend

The frontend is divided into two files, they are built using react, after installing npm or yarn on the machine, navigate to the file and run npm/yarn install.

The package.json file has the proxy adress, the api calls are set up using the proxy, as such the proxy will need to change based on the backend url. Once everything is set up that's it.


##Notes

The api has a /api/admin/register route that the frontend doesn't have set up due to the fact that admins usually shouldn't be able to register, the route is just there to populate the database and for testing.

It's a post route that takes the params:
email
password
password_confirmation

#Requirements

PHP >= 7.1.3
    BCMath PHP Extension
    Ctype PHP Extension
    JSON PHP Extension
    Mbstring PHP Extension
    OpenSSL PHP Extension
    PDO PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension
