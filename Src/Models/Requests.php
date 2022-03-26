<?php

namespace Src\Models;

use PDO;

/**
 * Class Requests
 *
 * @author  Adam Konstantinos <konstantinos@kadam.gr>
 * @license -
 * @package Src\Models
 * @since   1.0.0
 */
class Requests
{
    /**
     * The database table name.
     *
     * @since 1.0.0
     * @var   string
     */
    public const DATABASE_TABLE = 'requests';

    /**
     * The database connection.
     *
     * @since 1.0.0
     * @var   PDO
     */
    private PDO $db;

    /**
     * Requests model constructor
     *
     * @since  1.0.0
     */
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * This function creates the requests table.
     *
     * @return void
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function createTable(): void
    {
        $query = sprintf('
            CREATE TABLE IF NOT EXISTS `%s` (
              `id` INT AUTO_INCREMENT,
              `ip` VARCHAR (20) NOT NULL,
              `logTime` INT (15) NOT NULL,
              `action` VARCHAR (255) NOT NULL,
              CONSTRAINT `request_pk`
              PRIMARY KEY (`id`)
            );
        ',
            self::DATABASE_TABLE);

        $this->db->query($query);
    }

    /**
     * This function logs the action and checks if the IP has exceeded the maximum requests per hour.
     *
     * @param string $uri
     *          - The requested uri. (Required)
     * @param string $ip
     *          - The requested IP address. (Required)
     * @return bool
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function increaseAndCheck(string $uri, string $ip): bool
    {
        $query = sprintf('INSERT INTO `%s`
                    SET
                        `ip` = :ip, 
                        `logTime` = :logTime, 
                        `action` = :action',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($query);

        $time = time();

        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':logTime', $time);
        $stmt->bindParam(':action', $uri);

        $stmt->execute();

        $totalRequests = $this->getRequestsPerHour($ip);

        return 10 >= $totalRequests;
    }

    /**
     * This function returns the number of requests per hour for the given IP.
     *
     * @param string $ip
     *          - The requested IP address. (Required)
     * @return int
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    private function getRequestsPerHour(string $ip): int
    {
        $sqlQuery = sprintf('SELECT
                        count(`id`) AS `count`
                      FROM
                        `%s`
                    WHERE 
                       `ip` = ?
                    AND
                        `logTime` > ?
                    LIMIT 0,1',
            self::DATABASE_TABLE);

        $time = strtotime('-1 hour');

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $ip);
        $stmt->bindParam(2, $time);
        $stmt->execute();

        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$count['count'];
    }
}

