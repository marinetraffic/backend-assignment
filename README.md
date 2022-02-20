# Vessels Tracks API
```email
name: Elton Ibi 
email: ibi.elton@gmail.com
```

## Introduction
The  Vessels Tracks API  allows you to search vessels by HTTP requests.

## Requests
Any tool that is fluent in HTTP can communicate with the API simply by requesting the correct URI.
* Method:GET

##HTTP Statuses
* 200 OK
* 415 Unsupported Content-Type

##Parameters
* mmsi (integer) required
* fromdate (integer unix timestamp)
* todate (integer unix timestamp)
* longitudefrom (integer)
* longitudeto (integer)
* latitudefrom (integer)
* latitudefrom (integer)
* latitudeto (integer) 
* type (string) default value "xml" & supported values [json,xml,csv,hal]

##URI EXAMPLE
```url
http://{host}:{port}/api/ship?mmsi=311486000&fromdate=1372694880&todate=1372700100&longitudefrom=2.3985&longitudeto=50.3985&latitudefrom=9.01322&latitudeto=190.01322&type=json

```
##Authentication [N/A]

##Responses
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
##Rate Limit
* Requests through the API are rate limited per requested ip with rate limit is 10/hour.

