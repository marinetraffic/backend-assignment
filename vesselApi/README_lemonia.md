# Vessels Tracks API

INFO
The raw data supplied in JSON file are to be imported to database vesselPosition database using following API call
./vesselApi/index.php/loadFromJson

Database schema
vesselPosition.sql

Database dump after json import to db in file
vesselApi_db_2022-01-05_13-59-16.sql

Logs of incoming requests are of plain text and stored to vesselApi/logs folder

Ratelimiter based on remote ip is included in index.php

Support the following content types:
  * application/json, application/vnd.api+json
  * application/xml
  * text/csv

Testing
Only manual testing provided
Unfortunately it took much time to resolve issues with phpUnit framework, something that did not left me enough time to find how to mock http request and responses

API CALLS

- ./vesselApi/index.php/loadFromJson
import json to db

- ./vesselApi/index.php/listAll
List of all vessel positions extracted from db
parameter: limit

- ./vesselApi/index.php/getVessels
List of vessel positions extracted from db filtered by parameters provided
parameters: mmsi(multiple, instances), lon_min,lon_max,lat_min,lat_max,time_min,time_max





