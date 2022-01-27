<?php

use PHPUnit\Framework\TestCase;

require_once 'database/DBManager.php';
require_once 'app/Vessels.php';

class VesselsTest extends TestCase
{
    protected $connection;

    public function testCheckIpLimitPassed()
    {
        $vessels = new Vessels();

        $ip = '0.0.0.0';
        $_SERVER['REMOTE_ADDR'] = $ip;

        for ($i = 0; $i < 11; $i++) {
            $vessels->checkIp();
        }
        $finalResult = $vessels->checkIp();

        $query = 'DELETE FROM requests where ip = "' . $ip . '"';
        $this->connection->query($query);

        $this->assertFalse($finalResult, 'Test passed successfully!');
    }

    public function testCheckIpSucceed()
    {
        $vessels = new Vessels();
        //fake ip
        $ip = '0.0.0.1';
        $_SERVER['REMOTE_ADDR'] = $ip;

        $finalResult = $vessels->checkIp();

        $query = 'DELETE FROM requests where ip = "' . $ip . '"';
        $this->connection->query($query);

        $this->assertTrue($finalResult, 'Test passed successfully!');
    }

    public function testFetchesResults()
    {
        //fake ip
        $ip = '0.0.0.2';
        $query = 'DELETE FROM requests where ip = "' . $ip . '"';
        $this->connection->query($query);

        $vessels = new Vessels();
        $_SERVER['REMOTE_ADDR'] = $ip;

        $results = $vessels->index();

        $this->assertIsArray($results, 'Results are array!');
        $this->assertNotEmpty($results, 'Array is not empty!');
    }

    public function testFetchesResultsWithFilter()
    {
        //fake ip
        $ip = '0.0.0.2';
        $query = 'DELETE FROM requests where ip = "' . $ip . '"';
        $this->connection->query($query);

        $vessels = new Vessels();

        $_SERVER['REMOTE_ADDR'] = $ip;

        $_GET['mmsi'] = 311486000;
        $results = $vessels->index();

        $this->assertIsArray($results, 'Results are array!');
        $this->assertNotEmpty($results, 'Array is not empty!');
    }

    public function testEmptyResultsWithInvalidFilter()
    {
        $ip = '0.0.0.2';
        $query = 'DELETE FROM requests where ip = "' . $ip . '"';
        $this->connection->query($query);

        $vessels = new Vessels();

        $_SERVER['REMOTE_ADDR'] = $ip;
        //fake mmsi
        $_GET['mmsi'] = 'invalid filter';
        $results = $vessels->index();

        $this->assertIsArray($results, 'Results are array!');
        $this->assertEmpty($results, 'Array is empty!');
    }

    protected function setUp(): void
    {
        $DBManager = new DBManager();
        $this->connection = $DBManager->getConnection();
    }
}