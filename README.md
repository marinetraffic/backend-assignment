# Vessels Tracks API
```email
name: Elton Ibi 
email: ibi.elton@gmail.com
used: Laravel Framework 8.83.1

```

# Introduction
The  Vessels Tracks API  allows you to search vessels by HTTP requests.

# Requests
Any tool that is fluent in HTTP can communicate with the API simply by requesting the correct URI.
* Method:GET

# Authentication [N/A]
* Feature improvement add API-Key

# HTTP Statuses
* 200 OK
* 400 Bad Request
* 415 Unsupported Media Type

# Parameters

| Name     | Description       | Required |   Type   | Sample Value         |
| :---:    | :---:             | :---:    | :---:    | :---:                |
| mmsi     | Maritime Mobile Service Identity               | yes      | integer  | 311486000,311486001 |
| fromdate     | Start date               | no      | integer  |1372694880 |
| todate     | End date               | no      | integer  |1372694880 |    
| longitudefrom     |geographic coordinate {Min=-180 Max=180}            | no      | integer  | 50.3985 |  
| longitudeto     |geographic coordinate {Min=-180 Max=180}              | no      | integer  | 50.3985 |  
| latitudefrom     |geographic coordinate {Min=-90 Max=90}              | no      | integer  | 2.3985 |  
| latitudeto     |geographic coordinate {Min=-90 Max=90}             | no      | integer  | 50.3985 |  
| type     | default value "xml" & supported values [json,xml,csv,hal]           | no      | string  | csv |  

# Example Request
```url
http://{host}:{port}/api/ship?mmsi=311486000,311486001&fromdate=1372694880&todate=1372700100&longitudefrom=2.3985&longitudeto=50.3985&latitudefrom=9.01322&latitudeto=190.01322&type=json

```

# Responses
Response for an json Object Collection
```json
[
  {
    "mmsi": 311486000,
    "status": 0,
    "stationId": 1916,
    "speed": 153,
    "lat": 10.82863,
    "lon": 38.2366,
    "course": 101,
    "heading": 102,
    "rot": "",
    "timestamp": 1372683960
  },
  {
    "mmsi": 311486000,
    "status": 0,
    "stationId": 1931,
    "speed": 153,
    "lat": 11.00047,
    "lon": 38.20821,
    "course": 101,
    "heading": 102,
    "rot": "",
    "timestamp": 1372683960
  }
]
```
# Rate Limit
* Requests through the API are rate limited per requested ip with rate limit is 10/hour.

# Instructions
* Get clone of my branch "eltonibi" 
```code
git clone --branch=eltonibi https://github.com/eltonibi/backend-assignment.git .
```
* Install application dependencies with composer
```code
composer install
```

* Configure application environment
```code
Create environment file with name .env under root dir.
Config following variables:
APP_KEY=base64:jMuaFVDDVIkD6UQVpTi/dHh4+PyWKOFEOFSlrZXjhfc=
APP_DEBUG=false
APP_URL=your_host
DB_CONNECTION=mysql
DB_HOST=you_db_ip
DB_PORT=5432
DB_DATABASE=your_db_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
API_LOGGER_ENABLED=true
```

* Run application migrations in order to create application tables
```code
php artisan migrate
```
* Import sql data from ship_positions.sql to your database.
```code
INSERT INTO tracks(mmsi,status,stationId,speed,lon,lat,course,heading,rot,timestamp) VALUES (311040700,0,3372,156,31.70552,34.75784,284,286,NULL,1372700100);
..
..
INSERT INTO tracks(mmsi,status,stationId,speed,lon,lat,course,heading,rot,timestamp) VALUES (311040700,0,3367,157,31.7628,34.74562,284,284,NULL,1372696620);
```

#Tests
```code
\tests\Feature
```


