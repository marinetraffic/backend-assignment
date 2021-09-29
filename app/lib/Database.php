<?php

namespace App\Lib;

class Database
{
    private static $instance = null;
    private $conn;

    private $host  = 'localhost';
    private $user  = 'test';
    private $password   = "1234";
    private $database  = "vessel_tracking";

    private function __construct()
    {
        $conn = new \mysqli($this->host, $this->user, $this->password, $this->database);
        if ($conn->connect_error) {
            die("Error failed to connect to MySQL: " . $conn->connect_error);
        } else {
            return $this->conn = $conn;
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
