<?php
require_once 'load_env.php';

class DBManager
{
    public function getConnection()
    {
        $connection = mysqli_connect($_ENV['APP_ENV'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']) or die("Connection failed: " . mysqli_connect_error());
        mysqli_select_db($connection, $_ENV['DB_DATABASE']);
        return $connection;
    }
}