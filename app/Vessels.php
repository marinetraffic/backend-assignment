<?php
require_once 'database/DBManager.php';

class Vessels
{
    public $connection;

    public function __construct()
    {
        $DBManager = new DBManager();
        $this->connection = $DBManager->getConnection();
    }

    public function index()
    {
        $canAccess = $this->checkIp();

        if (!$canAccess) {
            http_response_code(403);
            die('Too many requests in 1 hour. Try again later');
        }

        $query = 'select * from ship_positions where 1';

        $filters = $this->applyFilters($query);

        $result = $this->connection->query($filters);

        $array = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
        }
        return [$array];
    }

    public function checkIp(): bool
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $currentHour = date("Y-m-d H:i:s", time());
        $oneHourAgo = date("Y-m-d H:i:s", time() - 3600);
        $countSql = 'SELECT * FROM requests WHERE ip = "' . $ip . '" AND time BETWEEN "' . $oneHourAgo . '" AND "' . $currentHour . '"';
        $result = mysqli_query($this->connection, $countSql);
        $count = mysqli_num_rows($result);

        if ($count > 10) {
            return false;
        }
        $insertRequestSql = 'INSERT INTO requests (ip, time) VALUES ("' . $ip . '", "' . $currentHour . '")';

        $this->connection->query($insertRequestSql);
        return true;
    }

    private function applyFilters($query)
    {
        //Filter for one or multiple "mmsi"
        $mmsi = $_GET['mmsi'] ?? null;

        if (isset($mmsi) && !empty($mmsi)) {
            if (gettype($mmsi) == 'array') {
                $query .= ' and mmsi in (' . implode(',', $mmsi) . ')';
            }
            if (gettype($mmsi) == 'string') {
                $query .= ' and mmsi = ' . $mmsi;
            }
        }

        //Filter for latitude range
        $fromLat = $_GET['from_lat'] ?? null;
        $toLat = $_GET['to_lat'] ?? null;

        if ((isset($fromLat) && !empty($fromLat)) && (isset($toLat) && !empty($toLat))) {
            $query .= ' and lat between "' . $fromLat . '" and "' . $toLat . '"';
        }

        //Filter for longitude range
        $fromLon = $_GET['from_lon'] ?? null;
        $toLon = $_GET['to_lon'] ?? null;

        if ((isset($fromLon) && !empty($fromLon)) && (isset($toLon) && !empty($toLon))) {
            $query .= ' and lon between "' . $fromLon . '" and "' . $toLon . '"';
        }

        //Filter for timestamp
        $unixTimestamp = $_GET['timestamp'] ?? null;
        if (isset($unixTimestamp) && !empty($unixTimestamp)) {
            $timestamp = date('Y-m-d H:i:s', $unixTimestamp);
            $query .= ' and timestamp = "' . $timestamp . '"';
        }

        return $query;
    }
}
