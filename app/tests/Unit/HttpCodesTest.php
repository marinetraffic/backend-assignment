<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\HttpCodes;

class HttpCodesTest extends TestCase {
    
    public function testOkHasCorrectCode() {
        $this->assertTrue(HttpCodes::OK == 200);
        $this->assertTrue(is_integer(HttpCodes::OK));
    }

    public function testBadRequestHasCorrectCode() {
        $this->assertTrue(HttpCodes::BAD_REQUEST == 400);
        $this->assertTrue(is_integer(HttpCodes::BAD_REQUEST));
    }

    public function testUnauthorizedHasCorrectCode() {
        $this->assertTrue(HttpCodes::UNAUTHORIZED == 401);
        $this->assertTrue(is_integer(HttpCodes::UNAUTHORIZED));
    }

    public function testNotFoundHasCorrectCode() {
        $this->assertTrue(HttpCodes::NOT_FOUND == 404);
        $this->assertTrue(is_integer(HttpCodes::NOT_FOUND));
    }

    public function testUnsupportedMediaHasCorrectCode() {
        $this->assertTrue(HttpCodes::UNSUPPORTED_MEDIA == 415);
        $this->assertTrue(is_integer(HttpCodes::UNSUPPORTED_MEDIA));
    }
}