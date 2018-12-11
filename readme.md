# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

##Installation

git clone https://amosaa@bitbucket.org/amosaa/sydneyquest.git

cd sydneyquest

cp .env-example .env

Значения полей DOMAIN и MAIN_DOMAIN необходимо переопределить в соответсвии с вашим доменом, например, если ваш сайт сайт - http://sidney.com, то значения должны быть такими:
DOMAIN=sydney
MAIN_DOMAIN=com

Установить поля DB_DATABASE, DB_USERNAME, DB_PASSWORD соответственно, в имя базы данных, логин и пароль к базе данных на вашем сервере.

./composer.phar install

php artisan migrate

php artisan db:seed

chmod -R 777 storage

chmod -R 777 bootstrap

chmod 777 public/images/uploads

## Passwords

Первоначально установленные пароли:

Супер админ:
test1@mail.com
test_34219_super_admin

Админ:
test2@mail.com
test_34219_admin

Контрибутор:
test3@mail.com
test_34219_contributor

## Вопросы

Все вопросы по email:
amosaa@mail.ru

Skype:
tosha055