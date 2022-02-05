Assignment done by Lauris Voitešonoks

## Setup

 1. clone from the repository.
 2. (optional) set up database environment variable in both `./source/.env` - DB_* variables and in`docker-compose.yaml` file, under "db:" service POSTGRES_* variables to your choice.
 3. start up the docker infrastructure (nginx, laravel app and postgresql)
```bash
docker-compose up -d
```
 - run the commands 
  ```bash
  docker exec -it laravel-php php artisan migrate
  ``` 
  and 
```bash
docker exec -it laravel-php php artisan db:seed
```

## Tests

 if necessary to run tests, use this command 
```bash
docker exec -it laravel-php php artisan test
```

## Usage
### Endpoint
API service after setup is available at either `http://localhost:80` or `http://127.0.0.1:80` (port 80 can be omitted)

There is 1 endpoint available: `http://127.0.0.1/api/v1/shippositions` as a GET request.

### Content Types
The endpoints supports several `Content-Type` attributes: `application/json`, `application/vnd.api+json`, `application/xml` and `text/csv`. Request to the endpoint **MUST** have a `Accept` header using one of supported content types.

### Filters
Additionally it supports filters, that are added as query parameters to API endpoint

 - mmsi filter (one or multiple): `filter[mmsi][]=`- note the end braces `[]`, those are necessary to support array of values. To have multiple values, just repeat the filter multiple times like so: `?filter[mmsi][]=12345678&filter[mmsi][]=1234569`
 - latitude range filtering. to support a range, filter is divided in two. `filter[lat-from]` and `filter[lat-to]`.
 - longitude range filters. `filter[lon-from]` and `filter[lon-to]`
 - timestamp range filters. `filter[timestamp-from]` and `filter[timestamp-to]`

### Example request

Example request using fiters, which should return a single entry:
```bash
curl --header "Accept: application/vnd.api+json" http://127.0.0.1/api/v1/shippositions?filter[mmsi][]=247039300&filter[mmsi][]=311040700&filter[lat-from]=43&filter[timestamp-from]=1372664880&filter[timestamp-to]=1372664880
```

### Logs

Logs of API access is available at `./source/storage/logs/api_access.log`.

### Note

ship_positions.json was copied over to `./source/app/database/data/` folder, for Laravel application to have access to it.

## Personal Note:
This was a challenge to accomplish in the evening of a work week. Getting a quick "crash course" on a language that I did not work in years, took a bit of limited time available for the assignment. But even with this, I was able to learn few neat tricks along the way, that I had no knowledge beforehand. 

#
#
#
# Assignment
#


# Vessels Tracks API

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
* Stage your solution on a demo page or
* Fork this repo and create a pull request that contains your implementation in a new branch named after you.
* Please include your Tests with your source code
* Include instructions

**Have fun!**