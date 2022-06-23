<p align="center">Marine Traffic.</p>
<p align="center"><a href="https://infinitypaul.medium.com">Creator</a> | <a href="https://marinetask.herokuapp.com/api/position">Demo URL</a></p>

## Tech Stack

* Laravel
* Mysql
* PHP

## Download Instruction

1. Clone the project.

```
git clone https://github.com/infinitypaul/backend-assignment.git projectname
```


2. Install dependencies via composer.

```
composer install 
```

3. Migrate and seed the Database.

```
php artisan migrate --seed
```

4. Run php server.

```
php artisan serve
```


## Api Usage

### Base URL
```
https://marinetask.herokuapp.com
```

#### List All Record:

```
https://marinetask.herokuapp.com/api/position
```

## Filter Conditions

### By MMSI

##### Single MMSI

```phpregexp
https://marinetask.herokuapp.com/api/position?mmsi=311040700
```

##### Multiple MMSI

```phpregexp
https://marinetask.herokuapp.com/api/position?mmsi=311040700,311486000
```

### By Time Inverter

```phpregexp
https://marinetask.herokuapp.com/api/position?time=2013-07-01T13:06:00,2013-07-01T10:06:00
```

### By Longitude And Latitude

```phpregexp
https://marinetask.herokuapp.com/api/position?latlong={latitude},{longitude}
https://marinetask.herokuapp.com/api/position?latlong=33.5577600,34.6411200
```

it can also accept multiple filter condition

```phpregexp
https://marinetask.herokuapp.com/api/position?latlong=33.5577600,34.6411200&time=2013-07-01T13:06:00,2013-07-01T10:06:00&mmsi=311040700,311486000&page=1
```



And Viola, You have the response in front of you.

Enjoy!!


