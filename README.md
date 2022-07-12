# Vessels Tracks API

# Implementation 
By **Theodore Mandilaras**

The implementation of this API, was done using the Laravel Framework. More specifically:

- PHP Version: 8.0
- Laravel Version: 9.1

As for the database I used MySQL, which gets migrated and populated by the api.

The total application can be easily build and deployed using Docker.
   
## Setup

The api and the database can be easily build by running:

```
docker-compose build
docker-compose up
```

To create the database schema and to populate it by the track data, run:
```
docker exec -it vessel_api php artisan app:setup
```

## Database Schema

For the needs of the API, two tables have been created:

**Tracks**: contains all the necessary fields
- mmsi
- status
- stationId
- speed
- lon
- lat
- course
- heading
- rot
- timestamp

**IncomingRequests**: In which the application logs all the incoming requests.
- id
- ip_address
- method
- endpoint
- params
- requested_at

The migration files for both of the tables can be found at `database/migrations`.

### CRUD 

The logic of the CRUD operations along with the requested filters can be found at `app/Http/Controllers/TaskController.php`,
For the filtering of the data, I developed a service which uses the Query Builder of Laravel, in
order to create the proper SQL statement for the requested filters.

The name of this Service is `TrackFilterer.php`.

To filter, the client has to provide one of the below params in the URL:
- mmsi: an array with one or more mmsis
- lon_range: an array with the min and max lon values. It must have exact 2 elements.
- lat_range: an array with the min and max lat values. It must have exact 2 elements.
- interval: an array with the starting and ending timestamps of interest. It must have exact 2 elements.

### Request Logging

For the request logging, a middleware have been used, named `LogRequests.php`. All the requests, before ending to the 
Controller have to pass from it. There, it stores the request in the database, at the `requests` table.

 ### Rate Limiting
 
 The rate limiting is configured in the `app/Providers/RouteServiceProvider.php` file.
 
 ### Support Different Content Types
 
 To support different content type, also a middleware have been created, which detects this types and process the data
 in order to suit with the controllers needs.
 
 The name of this middleware is: `ContentTypeMiddleware.php`

### Integration Tests

To test the application use: 
```
docker exec -it vessel_api php artisan test
```

There is a test for all the CRUD operations and the filtering. They can be found at `tests/Feature/ApiTest.php`
For testing, I use a memory-stored SQLite database, which is migrated and populated before the tests start.

### Last

To better evaluate the API, an Postman Collection is provided in the project.

If there is any issue in setting up or testing this api, please don't hesitate to ask me.

---

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
