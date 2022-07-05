# Vessels Tracks API

developed by Kleomenis Chatzigeorgiou

##Requirments
1) php 7.4
2) composer
3) SQL database


##Installation
1) navigate to vessel-tracks folder
2) rename .env.example to .env
3) open .env and fill accordingly: 
     - DB_CONNECTION=
     - DB_HOST=
     - DB_PORT=
     - DB_DATABASE=
     - DB_USERNAME=
     - DB_PASSWORD=
4) in order to migrate vessel data to the database, the file that contains the data must be name "ship_positions.json". It alson needs to be places at storage/app folder
5) run php artisan migrate 
6) run php artisan db:seed to migrate the vessel data

#### Tests
This project comes with a variety of unit tests. You can execute them by runing "php artisan test" in your terminal.

##API Documentation:
The url for API requests is : "<your_application_url>/api/position". For example if you are hosting the site through artisan (with php artisan serve command), the url is http://127.0.0.1:8000/api/position
#####Features
You can retrieve info about vessels by sending GET requests to the api. You can also filter data by mmsi (multiple or single comma seperated), date range and latitude and longitude. Moreover, you can combine all the filters together.

#####Supported Conntent Types
The API supports the following formats:
- application/XML
- application/json
- application/ld+json
- text/csv

The default format is application/json. If you want to get  the response in another format, you have to specify it in the headers under the key "Content-Type"

#####Parameters
- mssi , filters by the mssi number and accepts multiple values seperated by comma
- time , filters by time interval. Value should be seperated by comma 
- latlong , filters by latitude and longitude. Value should be seperated by come with latitude being the first value

#####Examples

- Get all records filtering by mssi: http://127.0.0.1:8000/api/position?mmsi=247039300
- Get all records filtering by multiple mssi :http://127.0.0.1:8000/api/position?mmsi=247039300,311486000
- Get all records filtering by latitude and longitude :http://127.0.0.1:8000/api/position?latlong=43.9751000,14.1760300
- Get all records filtering by time interval http://127.0.0.1:8000/api/position?time=2013-07-01T16:05:05,2014-03-01T16:05:05
- Get all records filtering by mssi and latitude and longitude http://127.0.0.1:8000/api/position?mmsi=247039300,311486000&time=2013-07-01T16:05:05,2014-03-01T16:05:05


