<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once('../fileLogger/Compatibility.php');
require_once('../fileLogger/FileLogger.php');

use fileLogger\Compatibility;
use fileLogger\CompatibilityException;
use fileLogger\FileLogger;


/**
 * vessel test case.
 */
class fileLoggerTest extends TestCase
{

  

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void 
    {
        parent::setUp();

        // TODO Auto-generated vesselTest::setUp()

    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
      
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }
    
    
    public function testLog()
    {
    	
		try {
		    $compat = Compatibility::check();
		} catch(CompatibilityException $e){
		    die($e->getMessage());
		}
		
		$log = new FileLogger(__DIR__.'/logs/example.log.php');
		
		$log->log('Example Notice', FileLogger::NOTICE);
		$log->log('Example Warning', FileLogger::WARNING);
		$log->log('Example Error', FileLogger::ERROR);
		$log->log('Example Fatal', FileLogger::FATAL);
		

    }
}





