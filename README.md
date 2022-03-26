# Instructions

Install composer
* composer install

Before you begin, you need to add the database credentials in the `Src/Models/Database.php` file. More specifically:
1. Database username: Change the `private string $username` variable.
2. Database user password: Change the `private string $password` variable.

If the above credentials doesn't work or if the MySQL server is down, a message will appear in the screen informing you accordingly.

Upon first run, the script will create the Database and populate it and then the execution will resume.

Run tests with the following command
* composer tests

#Testing

1. Return all vessels:
   1. `JSON` response
      1. http://marinetraffic.test/json
   2. `XML` response
      1. http://marinetraffic.test/xml
   3. `CSV` response
      1. http://marinetraffic.test/csv
2. One `mmsi` filter:
   1. `JSON` response
      1. http://marinetraffic.test/json/mmsi/247039300
   2. `XML` response
      1. http://marinetraffic.test/xml/mmsi/247039300
   3. `CSV` response
      1. http://marinetraffic.test/csv/mmsi/247039300
3. Multiple `mmsi` filters:
   1. `JSON` response
       1. http://marinetraffic.test/json/mmsi/247039300,311486000
   2. `XML` response
       1. http://marinetraffic.test/xml/mmsi/247039300,311486000
   3. `CSV` response
       1. http://marinetraffic.test/csv/mmsi/247039300,311486000
4. Latitude
   1. `From` & `To`
      1. `JSON` response
         1. http://marinetraffic.test/json/lat/from/12/to/36
      2. `XML` response
          1. http://marinetraffic.test/xml/lat/from/12/to/36
      3. `CSV` response
          1. http://marinetraffic.test/csv/lat/from/12/to/36
   2. Only `From`
      1. `JSON` response
         1. http://marinetraffic.test/json/lat/from/12
      2. `XML` response
          1. http://marinetraffic.test/xml/lat/from/12
      3. `CSV` response
          1. http://marinetraffic.test/csv/lat/from/12
   3. Only `To`
      1. `JSON` response
         1. http://marinetraffic.test/json/lat/to/36
      2. `XML` response
          1. http://marinetraffic.test/xml/lat/to/36
      3. `CSV` response
          1. http://marinetraffic.test/csv/lat/to/36
5. Longitude
    1. `From` & `To`
        1. `JSON` response
            1. http://marinetraffic.test/json/lon/from/12/to/36
        2. `XML` response
            1. http://marinetraffic.test/xml/lon/from/12/to/36
        3. `CSV` response
            1. http://marinetraffic.test/csv/lon/from/12/to/36
    2. Only `From`
        1. `JSON` response
            1. http://marinetraffic.test/json/lon/from/12
        2. `XML` response
            1. http://marinetraffic.test/xml/lon/from/12
        3. `CSV` response
            1. http://marinetraffic.test/csv/lon/from/12
    3. Only `To`
        1. `JSON` response
            1. http://marinetraffic.test/json/lon/to/36
        2. `XML` response
            1. http://marinetraffic.test/xml/lon/to/36
        3. `CSV` response
            1. http://marinetraffic.test/csv/lon/to/36
6. Timestamp
    1. `JSON` response
        1. http://marinetraffic.test/json/timestamp/1372700340
    2. `XML` response
        1. http://marinetraffic.test/xml/timestamp/1372700340
    3. `CSV` response
        1. http://marinetraffic.test/csv/timestamp/1372700340

Every single request is logged in the database and there is also a check for a 10 requests per hour per IP policy.