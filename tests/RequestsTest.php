<?php

use PHPUnit\Framework\TestCase;
use Src\Models\Database;
use Src\Models\Requests;

/**
 * Class RequestsTest
 *
 * @author  Adam Konstantinos <konstantinos@kadam.gr>
 * @license -
 * @package Tests
 * @since   1.0.0
 */
final class RequestsTest extends TestCase
{
    /**
     * Tests that for a specific IP can't abuse the application (applies the 10 request per hour per IP limit).
     *
     * @return void
     * @throws Exception
     *          - In case the operation fails.
     * @since  1.0.0
     */
    public function testIpLimit()
    {
        require_once sprintf('%s%svendor/autoload.php', dirname(__DIR__), DIRECTORY_SEPARATOR);
        $db = (new Database())->getConnection();
        for ($i = 0; $i < 9; $i++) {
            (new Requests($db))->increaseAndCheck('/testCase', '0.0.0.0');
        }

        $testResultTrue = (new Requests($db))->increaseAndCheck('/testCase', '0.0.0.0');
        $testResultFalse = (new Requests($db))->increaseAndCheck('/testCase', '0.0.0.0');

        static::assertTrue($testResultTrue, 'Test allowed request successful.');
        static::assertFalse($testResultFalse, 'Test blocked request successful.');
    }
}