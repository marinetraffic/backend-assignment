<?php

use PHPUnit\Framework\TestCase;
use Src\Models\Database;
use Src\Models\Vessels;

/**
 * Class VesselTest
 *
 * @author  Adam Konstantinos <konstantinos@kadam.gr>
 * @license -
 * @package Tests
 * @since   1.0.0
 */
final class VesselTest extends TestCase
{
    /**
     * Tests that for a given mmsi, the results will be empty (mmsi doesn't exist) or not empty (mmsi exist).
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testGetVesselByMmsi()
    {
        require_once '../vendor/autoload.php';
        $db = (new Database())->getConnection();

        $resultsEmpty = (new Vessels($db))->getByMmsi(123456789);
        self::assertEmpty($resultsEmpty, 'Wrong mmsi with empty results.');

        $resultsNotEmpty = (new Vessels($db))->getByMmsi(247039300);
        self::assertNotEmpty($resultsNotEmpty, 'Correct mmsi with plenty of results.');
    }

    /**
     * Tests that for a given from lon (that exists), the results will not be empty.
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testGetVesselByLonFrom()
    {
        require_once '../vendor/autoload.php';
        $db = (new Database())->getConnection();

        $results = (new Vessels($db))->getByLonFrom(14.1);
        self::assertNotEmpty($results, 'Correct results.');
    }

    /**
     * Tests that for a given to lon (that exists), the results will not be empty.
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testGetVesselByLonTo()
    {
        require_once '../vendor/autoload.php';
        $db = (new Database())->getConnection();

        $results = (new Vessels($db))->getByLonTo(14.1);
        self::assertNotEmpty($results, 'Correct results.');
    }

    /**
     * Tests that for a given from lat (that exists), the results will not be empty.
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testGetVesselByLatFrom()
    {
        require_once '../vendor/autoload.php';
        $db = (new Database())->getConnection();

        $results = (new Vessels($db))->getByLatFrom(34.6);
        self::assertNotEmpty($results, 'Correct results.');
    }

    /**
     * Tests that for a given to lon (that exists), the results will not be empty.
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testGetVesselByLatTo()
    {
        require_once '../vendor/autoload.php';
        $db = (new Database())->getConnection();

        $results = (new Vessels($db))->getByLatTo(41.8);
        self::assertNotEmpty($results, 'Correct results.');
    }

    /**
     * Tests that for a given lat range (that exists), the results will not be empty.
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testGetVesselByLat()
    {
        require_once '../vendor/autoload.php';
        $db = (new Database())->getConnection();

        $results = (new Vessels($db))->getByLat(15.1, 42.6);
        self::assertNotEmpty($results, 'Correct results.');
    }

    /**
     * Tests that for a given lon range (that exists), the results will not be empty.
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testGetVesselByLon()
    {
        require_once '../vendor/autoload.php';
        $db = (new Database())->getConnection();

        $results = (new Vessels($db))->getByLon(15.1, 41.9);
        self::assertNotEmpty($results, 'Correct results.');
    }

    /**
     * Tests that for a given timestamp (that exists), the results will not be empty.
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testGetVesselByTimestamp()
    {
        require_once '../vendor/autoload.php';
        $db = (new Database())->getConnection();

        $results = (new Vessels($db))->getByLonTo(1372635240);
        self::assertNotEmpty($results, 'Correct results.');
    }
}