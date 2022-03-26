<?php

namespace Src\Models;

use PDO;

/**
 * Class Vessels
 *
 * @author  Adam Konstantinos <konstantinos@kadam.gr>
 * @license -
 * @package Src\Models
 * @since   1.0.0
 */
class Vessels
{
    /**
     * The database table name.
     *
     * @since 1.0.0
     * @var   string
     */
    public const DATABASE_TABLE = 'vessels';

    /**
     * The database connection.
     *
     * @since 1.0.0
     * @var   PDO
     */
    private PDO $db;

    /**
     * Vessels model constructor
     *
     * @since  1.0.0
     */
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * This function creates the vessels table.
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
                `id`        INT AUTO_INCREMENT,
                `mmsi`      INT(15)     NOT NULL,
                `status`    INT(5)      NOT NULL,
                `stationId` INT(5)      NOT NULL,
                `speed`     INT(5)      NOT NULL,
                `lon`       FLOAT(6, 3) NOT NULL,
                `lat`       FLOAT(6, 3) NOT NULL,
                `course`    INT(5)      NOT NULL,
                `heading`   INT(5)      NOT NULL,
                `rot`       VARCHAR(20) NOT NULL,
                `timestamp` INT(15)     NOT NULL,
                CONSTRAINT `vessels_pk`
                    PRIMARY KEY (`id`)
            );
        ',
            self::DATABASE_TABLE);

        $this->db->query($query);

        $this->populateVessels();
    }

    /**
     * This function populates the requests table.
     *
     * @return void
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    private function populateVessels(): void
    {
        $jsonData = @file_get_contents(sprintf('%s%sship_positions.json', dirname(__DIR__, 2), DIRECTORY_SEPARATOR));

        if ($jsonData) {
            $data = json_decode($jsonData, true);

            foreach ($data as $datum) {
                $this->insertFromJson($datum);
            }

        } else {
            echo 'JSON file couldn\'t be loaded.';
            exit;
        }
    }

    /**
     * This function adds to the database a single row from the given JSON.
     *
     * @param array $column
     *          - The JSON column to be added. (Required)
     * @return void
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    private function insertFromJson(array $column): void
    {
        $query = sprintf('INSERT INTO `%s`
                    SET
                        `mmsi` = :mmsi, 
                        `status` = :status, 
                        `stationId` = :stationId, 
                        `speed` = :speed, 
                        `lon` = :lon, 
                        `lat` = :lat, 
                        `course` = :course, 
                        `heading` = :heading, 
                        `rot` = :rot, 
                        `timestamp` = :timestamp',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':mmsi', $column['mmsi']);
        $stmt->bindParam(':status', $column['status']);
        $stmt->bindParam(':stationId', $column['stationId']);
        $stmt->bindParam(':speed', $column['speed']);
        $stmt->bindParam(':lon', $column['lon']);
        $stmt->bindParam(':lat', $column['lat']);
        $stmt->bindParam(':course', $column['course']);
        $stmt->bindParam(':heading', $column['heading']);
        $stmt->bindParam(':rot', $column['rot']);
        $stmt->bindParam(':timestamp', $column['timestamp']);

        $stmt->execute();
    }

    /**
     * This function retrieves the rows from the database for a given mmsi.
     *
     * @param int $mmsi
     *          - The JSON column to be added. (Required)
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getByMmsi(int $mmsi): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM
                        `%s`
                    WHERE 
                       `mmsi` = ? ',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $mmsi);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function retrieves all the row from the database.
     *
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getAll(): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM `%s`',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function retrieves the rows from the database for a given from and to lon.
     *
     * @param float $fromLon
     *          - The from value for lon. (Required)
     * @param float $toLon
     *          - The to value for lon. (Required)
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getByLon(float $fromLon, float $toLon): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM
                        `%s`
                    WHERE 
                       `lon` BETWEEN ? AND ? ',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $fromLon);
        $stmt->bindParam(2, $toLon);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function retrieves the rows from the database for a given from and to lat.
     *
     * @param float $fromLat
     *          - The from value for lon. (Required)
     * @param float $toLat
     *          - The to value for lon. (Required)
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getByLat(float $fromLat, float $toLat): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM
                        `%s`
                    WHERE 
                       `lat` BETWEEN ? AND ? ',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $fromLat);
        $stmt->bindParam(2, $toLat);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function retrieves the rows from the database for a given to lon.
     *
     * @param float $param
     *          - The to value for lon. (Required)
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getByLonTo(float $param): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM
                        `%s`
                    WHERE 
                       `lon` < ? ',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $param);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function retrieves the rows from the database for a given from lon.
     *
     * @param float $param
     *          - The from value for lon. (Required)
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getByLonFrom(float $param): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM
                        `%s`
                    WHERE 
                       `lon` > ? ',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $param);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function retrieves the rows from the database for a given to lat.
     *
     * @param float $param
     *          - The to value for lat. (Required)
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getByLatTo(float $param): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM
                        `%s`
                    WHERE 
                       `lat` < ? ',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $param);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function retrieves the rows from the database for a given from lat.
     *
     * @param float $param
     *          - The from value for lat. (Required)
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getByLatFrom(float $param): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM
                        `%s`
                    WHERE 
                       `lat` > ? ',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $param);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function retrieves the rows from the database for a given timestamp.
     *
     * @param int $timestamp
     *          - The timestamp value. (Required)
     * @return bool|array
     * @throws \Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function getByTimestamp(int $timestamp): bool|array
    {
        $sqlQuery = sprintf('SELECT
                `mmsi`,
                `status`,
                `stationId`,
                `speed`,
                `lon`,
                `lat`,
                `course`,
                `heading`,
                `rot`,
                `timestamp`
                      FROM
                        `%s`
                    WHERE 
                       `timestamp` = ? ',
            self::DATABASE_TABLE);

        $stmt = $this->db->prepare($sqlQuery);
        $stmt->bindParam(1, $timestamp);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}




