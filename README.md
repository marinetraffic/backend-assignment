#Instructions
To run the project I have created a virtual host on my machine and directed it to the `index.php` file <br>
Feel free to do the same

Create a copy of `.env.example` and name it `.env`
* cp .env.example .env
* Name the variables at `.env` with your credentials 

Install composer
* composer install

Migrate the database with the following command
* composer migrate

Run tests with the following command
* composer tests

<h3>Testing filters</h3>
<h4>**mmsi**</h4>
* **Example:**
* One `mmsi` filter:
  
* http://marine.test/?mmsi=247039300
* Multiple `mmsi` filters: 
* http://marine.test/?mmsi[]=247039300,20311486000

<h4>**latitude**</h4>
* **Example:**
* `latitude` range filter:
* need to pass 2 parameters `from_lat` & `to_lat`
  
* http://marine.test/?from_lat=42.7518&to_lat=44.2664

<h4>**longitude**</h4>
* **Example:**
* `longitude` range filter:
* need to pass 2 parameters `from_lon` & `to_lon`

* http://marine.test/?from_lon=10.8286&to_lon=16.7439

<h4>**timestamp**</h4>
* **Example:**
* `timestamp` timestamp filter:
* http://marine.test/?timestamp=1372683960

<h4>**If 10 requests are made from the same IP an error will be thrown:**</h4>
`Too many requests in 1 hour. Try again later`

<h3>Made with love, from Kevin</h3>