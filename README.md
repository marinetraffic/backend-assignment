# Vessels Tracks API

## Technologies

* Laravel v8.75
* PHP v7.4
* MySQL/SQLite

## Downloading

Clone the project `git clone https://github.com/sdkcodes/vessel-trackr.git`

Change into the new project directory

## Configuration

Install dependencies `composer install`

Create environment variables file using `cp .env.example .env`

Run `php artisan key_generate` to create encryption key in the .env file

Open the .env file and fill in the database details

Create database schema by running `php artisan migrate`

Run `php artisan db:populate` to populate the database with data

## Testing

Run `php artisan test` to run phpunit tests

The app will most likely be running on `http://127.0.0.1:8000`

## Serving App

In the root directory, run `php artisan serve` to serve the app.

The app will most likely be running

## API Documentation

###### Fetch all track positions

URL: http://127.0.0.1:8000/api/v1/positions

Query Parameters

* mmsi: comma separated list of mmsi identifiers e.g 12908383,12983384
* lat: comma separated list of two latitude value ranges e.g 49.2829383,42.3984758
* lon: comma separated list of two longitude value ranges e.g 41.2829383,44.3984758
* time_inveral: comma separated list of two time intervals (epoch time) e.g 1372699980,1372698900

Full url example: 

http://127.0.0.1:8000/api/v1/positions?mmsi=12908383,12983384&lat=49.2829383,42.3984758&lon=41.2829383,44.3984758&time_interval=1372699980,1372698900

<hr>

Your task is to create a **RESTful API** that serves vessel tracks from a raw vessel positions data-source.
The raw data is supplied as a JSON file that you must import to a database schema of your choice.

Fields supplied are:

* **mmsi**: unique vessel identifier
* **status**: AIS vessel status
* **station**: receiving station ID
* **speed**: speed in knots x 10 (i.e. 10,1 knots is 101)
* **lon**: longitude
* **lat**: latitude
* **course**: vessel's course over ground
* **heading**: vessel's true heading
* **rot**: vessel's rate of turn
* **timestamp**: position timestamp

**The API end-point must:**

* Support the following filters:
  * **mmsi** (single or multiple)
  * **latitude** and **longitude range**
  * as well as **time interval**.
* Log incoming requests to a datastore of  your choice (plain text, database, third party service etc.)
* Limit requests per user to **10/hour**. (Use the request remote IP as a user identifier)
* Support the following content types:
  * At least two of the following: application/json, application/vnd.api+json, application/ld+json, application/hal+json
  * application/xml
  * text/csv

**Share your work:**

* Fork this repo and create a pull request that contains your implementation in a new branch named after you.

**Notes:**

* Please include your Tests with your source code
* Include instructions
* Feel free to use the framework, libraries of your choice or plain PHP to implement the assignment

**Have fun!**
