<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Mixtape

Laravel is a Music Collection App, it allows to add albums from the artists provided by the endpoint.

- There are two roles (Admin and User), Users can add and edit albums, Admin can also delete albums.
- It doesn't allow to create a album with same name for the same artist.
- It retrieves information from twitter about the artist list (including a profile picture) using the Twitter API 2.0. This is cached to spare resources.
- 
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.
## Technologies
- [MySql] (https://www.mysql.com/)
- [Laravel] (https://laravel.com/)
- [Bootstrap] (https://getbootstrap.com/)

## Running
- Execute ```composer install```
- Execute ```php artisan migrate```
- Rename the file .env.example inside the project folder to .env and change all the parameters that you wish
- the TWITTER_BEARER_TOKEN inside must be the developer account bearer token from the twitter. If not set the app will take default informations and pictures.

### docker-compose
- If using docker-compose mysql host must be 'mysql' as in the .env.example. If not it must be the mysql ip.


