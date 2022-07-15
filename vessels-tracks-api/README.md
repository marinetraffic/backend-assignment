# Setup Repo

Run the commands below, inside a terminal that is open in vessels-tracks-api directory.

`./vendor/bin/sail up` to start the project
`./vendor/bin/sail artisan migrate:fresh --seed` to create the database schema and insert the data from the json

# How to use the API

The only REST API Endpoint is /ShipLocation (eg. localhost/ShipLocation)

When we call it without any parameters or headers, it will return the whole dataset.

The REST API Endpoint /ShipLocation was created to use the properties below as query parameters, json properties, xml tags or csv records.

MMSI integer You can send multiple MMSIs and the endpoint will return their union
MaxLon float Maximum Longtitude value
MinLon float Minimum Longtitude value
MaxLat float Maximum Latitude value
MinLat float Minimum Latitude value
MaxTimestamp integer Maximum Timestamp value
MinTimestamp integer Minimum Timestamp value

These are all optional.

examples:

## Query Parameters

To find the Vessel tracks locations for mmsi 247039300 after timestamp 1372683960 we can call:

http://localhost/api/ShipPosition?MMSI=247039300&MinTimestamp=1372683960

## JSON

1. Send your GET request to http://localhost/api/ShipPosition
2. Add a json as request body
3. Set Content-Type header = application/json:

Example of request body:

```
{
	"MMSI": 247039300,
	"MinTimestamp": 1372683960
}
```

## XML

1. Send your GET request to http://localhost/api/ShipPosition
2. Add an xml as request body
3. Set Content-Type header = application/xml:

Example of request body:

```
<root>
	<MMSI>247039300</MMSI>
	<MinTimestamp>1372683960</MinTimestamp>
</root>
```

## CSV

1. Send your GET request to http://localhost/api/ShipPosition
2. Add a csv as request body
3. Set Content-Type header = text/csv:

Example of request body:

```
MMSI,MinTimestamp
247039300,1372683960
```