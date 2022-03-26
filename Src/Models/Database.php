<?php

namespace Src\Models;

use PDO;
use PDOException;

/**
 * Class Database
 *
 * @author  Adam Konstantinos <konstantinos@kadam.gr>
 * @license -
 * @package Src\Models
 * @since   1.0.0
 */
class Database
{
    /**
     * Database Host.
     *
     * @since 1.0.0
     * @var   string
     */
    private string $host = 'localhost';

    /**
     * Database name.
     *
     * @since 1.0.0
     * @var   string
     */
    private string $database_name = 'marinetraffic';

    /**
     * Database user.
     *
     * @since 1.0.0
     * @var   string
     */
    private string $username = 'root';

    /**
     * Database password.
     *
     * @since 1.0.0
     * @var   string
     */
    private string $password = '';

    /**
     * Database PDO Connection.
     *
     * @since 1.0.0
     * @var   ?PDO
     */
    public ?PDO $conn;

    /**
     * Database model constructor
     *
     * @throws PDOException
     *          - In case PDO fails to connect to database.
     * @since  1.0.0
     */
    public function __construct()
    {
        $pdo = new PDO(sprintf('mysql:host=%s', $this->host), $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->query(sprintf('CREATE DATABASE IF NOT EXISTS `%s`', $this->database_name));
        $pdo->query(sprintf('USE `%s`', $this->database_name));
    }

    /**
     * Performs the connection to the database and return the PDO object.
     *
     * @return ?PDO
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getConnection(): ?PDO
    {
        $this->conn = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=UTF8', $this->host, $this->database_name), $this->username, $this->password);
        $this->conn->exec('set names utf8');
        return $this->conn;
    }
}