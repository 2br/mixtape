<p align="center"><a href="http://mixtape.ga" target="_blank"><img src="https://raw.githubusercontent.com/2br/mixtape/main/public/images/logo.png" width="400">
<h1>Mixtape</h1></a></p>

## About Mixtape

Mixtape is a Music Collection App, it allows to add albums from the artists provided by the endpoint.

- There are two roles (Admin and User), Users can add and edit albums, Admin can also delete albums.
- It doesn't allow to create a album with same name for the same artist.
- It retrieves information from twitter about the artist list (including a profile picture) using the Twitter API 2.0. This is cached to avoid API calls.


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


