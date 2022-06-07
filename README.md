# Vessels Tracks API

## About

This repository contains the implementation of a RESTful API
written in Laravel by George Chatzipavlou (github.com/saimpot) for Backend Assignment from Marine Traffic.
The backend framework used for this assignment is Laravel (9.1)

## Preqrequisites

* PHP 8.1
* php-xml extension
* php-mbstring extension
* php-mysql for the correct php version. (In my case php8.1-mysql was required)

## Installation Instructions

* Clone the repository from github using the `git clone` command.
* Then use `composer install` to install all dependencies.
* Copy `.env.example` file by using `cp .env.example .env`.
* Then run `php artisan key:generate` to generate a secure application key.
* Open newly created `.env` file and edit all the `{{ CHANGE_ME }}` variables. In particular interest is the `DB_DATABASE`.
* You should create a database table with that name after you've edited the variable. This is going to be the table in the database that holds all the persisted data.
* Run `php artisan migrate`
* Run `php artisan db:seed

## Usage

* Use `GET http://marinetraffic.local/api/vessels/track`

### Available content types

* `application/json` (default),
* `text/csv`,
* `application/xml`

### Available filters

* `mmsi` - Example: `GET http://marinetraffic.local/api/vessels/track?mmsi=1`
* multiple `mmsi` - Example: `GET http://marinetraffic.local/api/vessels/track?mmsi=1,2,5,4,6`
* `coordinates` - Example: `GET http://marinetraffic.local/api/vessels/track?coordinates=15.4415,42.75178`
* `timestamps` - Example: `GET http://marinetraffic.local/api/vessels/track?timestamps=2013-07-01 13:06:00,2013-07-01 13:10:00`

### Full Url example

`GET http://marinetraffic.local/api/vessels/track?coordinates=15.4415,42.75178&timestamps=2013-07-01 13:06:00 2013-08-02 13:10:00&mmsi=247039301,247039300`

## Testing

There are unit tests and feature tests available. Use `php artisan test` to run the test suite.
