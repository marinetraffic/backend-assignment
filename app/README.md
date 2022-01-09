# Backend assignment implementation

### Requirements
1. PHP ^7.4|^8.0
2. Laravel ^8.75
3. PostgreSQL ^14.0.1
4. Docker 
5. PHPUnit ^9.5.10

### DB installation 
1. Run: docker run --name backend-assignment -e POSTGRES_PASSWORD=mysecretpassword -p 5432:5432  -d postgres
2. Connect with a DB client or CLI to running Postgres instance (hopefully running on 127.0.0.1:5432) and create databases:
    1. backend-assignment
   2. backend-assignment-testing


### Application Installation
1. cd app to Laravel application directory
2. Run composer install
3. Run php artisan key:generate
4. cp .env.example .env and add your database credentials
5. cp .env.example .env.testing and add your testing database credentials
6. Rate limit is configurable with a default value of 10 requests/hour. To change it add 'RATE_LIMIT' => xx to your .env file
7. Run command: php artisan migrate
8. 
   1. If you want to import ship_positions.json file located in root directory run command: php artisan import:file
   2. If you want to import another similar file run command: php artisan import:file "FULL_PATH_TO_FILE"
   3. If you want to truncate database before import add option "--truncate" to previous command
9. Run command: php artisan serve
10. Application is hopefully running on http://localhost:8000 


### Usage
1. Use a http client and send GET request to http://localhost:8000/api/positions
2. Add header 'Content-Type' with values:
   1. "application/json"
   2. "application/xml"
   3. "text/csv"
   4. "application/ld+json"
      (NOTICE: If Content-type is absent or not one of the above values you should receive a 415 error)
3. You can filter API results by adding the following query parameters:
   1. mmsi
   2. maxLat
   3. minLat
   4. maxLon
   5. minLon
   6. fromDatetime (format: YYYY-DD-MM hh:mm:ss / eg. 2013-07-02 17:44:00)
   7. toDatetime (format: YYYY-DD-MM hh:mm:ss / eg. 2013-07-02 17:44:00)
4. Tried to add to make OpenApi documentation for tha API did not manage to finish it: http://localhost:8000/api/documentation

### Testing
To run tests run command: php artisan test

### Logging
Logs are stored in txt format in files inside app/storage/logs directory following this naming format api_logging01_05_2022.log

### Thank you for your time!
/b
