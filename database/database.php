<?php
require_once 'database/DBManager.php';

$DBManager = new DBManager();
$connection = $DBManager->getConnection();

//check if database exists
$result = mysqli_select_db($connection, $_ENV['DB_DATABASE']);

if ($result == false) {
    //Create database
    $databaseCreationSql = 'CREATE DATABASE ' . $_ENV['DB_DATABASE'];
    if (mysqli_query($connection, $databaseCreationSql)) {
        echo "Database created successfully \n";
    } else {
        echo "Error creating database: " . mysqli_error($connection);
    }

    //Create table ship_positions
    mysqli_select_db($connection, $_ENV['DB_DATABASE']);

    $shipPositionsTableCreationSql = 'CREATE TABLE IF NOT EXISTS ship_positions (
    id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mmsi int NOT NULL,
    status int NOT NULL,
    station_id int NOT NULL,
    speed int NOT NULL,
    lon float NOT NULL,
    lat float NOT NULL,
    course int NOT NULL,
    heading int NOT NULL,
    rot varchar (255) NOT NULL,
    timestamp timestamp NOT NULL)';

    if ($connection->query($shipPositionsTableCreationSql) === TRUE) {
        echo "Table ship_positions created successfully \n";
    } else {
        echo "Error creating table ship_positions: " . $connection->error;
    }

    $requestsTableCreationSql = 'CREATE TABLE IF NOT EXISTS requests (
    id int UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip varchar (255) NOT NULL,
    time timestamp NOT NULL)';

    if ($connection->query($requestsTableCreationSql) === TRUE) {
        echo "Table requests created successfully \n";
    } else {
        echo "Error creating table requests: " . $connection->error;
    }

    //Insert data into ship_positions from json file
    $insertSql = 'INSERT INTO ship_positions (mmsi, status, station_id, speed, lon, lat, course, heading, rot, timestamp) VALUES ';
    $file = file_get_contents('ship_positions.json');
    $content = json_decode($file);
    foreach ($content as $item) {
        $timestamp = $item->timestamp;
        unset($item->rot, $item->timestamp);
        $items = implode(',', array_filter((array)$item, 'strlen'));
        //add rot and formatted timestamp
        $insertSql .= '(' . $items . ',"","' . date('Y-m-d H:i:s', $timestamp) . '"),';
    }
    //remove last comma from the string
    $insertSql = substr($insertSql, 0, -1);

    if ($connection->query($insertSql) === TRUE) {
        echo "Records added successfully";
    } else {
        echo "Error adding records: " . $connection->error;
    }
} else {
    echo 'Database already migrated!';
}

mysqli_close($connection);
