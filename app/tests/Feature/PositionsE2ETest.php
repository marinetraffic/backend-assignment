<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PositionsE2ETest extends TestCase {
    public function testGetPositionsByASingleVesselIdRoute() {
        $response = $this->get('/api/positions/247039300');
        
        $response->assertStatus(200);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['status']);
        $this->assertGreaterThan(0, count($response['data']));

        // Check if one of the position objects contain all the expected
        // properties that a position object should.
        $this->assertArrayHasKey('mmsi', $response['data'][0]);
        $this->assertArrayHasKey('status', $response['data'][0]);
        $this->assertArrayHasKey('stationid', $response['data'][0]);
        $this->assertArrayHasKey('speed', $response['data'][0]);
        $this->assertArrayHasKey('lon', $response['data'][0]);
        $this->assertArrayHasKey('lat', $response['data'][0]);
        $this->assertArrayHasKey('course', $response['data'][0]);
        $this->assertArrayHasKey('heading', $response['data'][0]);
        $this->assertArrayHasKey('rot', $response['data'][0]);
        $this->assertArrayHasKey('timestamp', $response['data'][0]);

        // Check the datatypes of all the properties of a position object.
        $this->assertTrue(is_integer($response['data'][0]['mmsi']));
        $this->assertTrue(is_integer($response['data'][0]['status']));
        $this->assertTrue(is_integer($response['data'][0]['stationid']));
        $this->assertTrue(is_integer($response['data'][0]['speed']));
        $this->assertTrue(is_double($response['data'][0]['lon']));
        $this->assertTrue(is_double($response['data'][0]['lat']));
        $this->assertTrue(is_integer($response['data'][0]['course']));
        $this->assertTrue(is_integer($response['data'][0]['heading']));
        $this->assertTrue(is_string($response['data'][0]['rot']));
        $this->assertTrue(is_integer($response['data'][0]['timestamp']));
    }

    public function testGetPositionsByMultipleVesselIdsRoute() {
        $response = $this->get('/api/positions/247039300,311040700');
        
        $response->assertStatus(200);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['status']);
        $this->assertGreaterThan(0, count($response['data']));

        // Check if one of the position objects contain all the expected
        // properties that a position object should.
        $this->assertArrayHasKey('mmsi', $response['data'][0]);
        $this->assertArrayHasKey('status', $response['data'][0]);
        $this->assertArrayHasKey('stationid', $response['data'][0]);
        $this->assertArrayHasKey('speed', $response['data'][0]);
        $this->assertArrayHasKey('lon', $response['data'][0]);
        $this->assertArrayHasKey('lat', $response['data'][0]);
        $this->assertArrayHasKey('course', $response['data'][0]);
        $this->assertArrayHasKey('heading', $response['data'][0]);
        $this->assertArrayHasKey('rot', $response['data'][0]);
        $this->assertArrayHasKey('timestamp', $response['data'][0]);

        // Check the datatypes of all the properties of a position object.
        $this->assertTrue(is_integer($response['data'][0]['mmsi']));
        $this->assertTrue(is_integer($response['data'][0]['status']));
        $this->assertTrue(is_integer($response['data'][0]['stationid']));
        $this->assertTrue(is_integer($response['data'][0]['speed']));
        $this->assertTrue(is_double($response['data'][0]['lon']));
        $this->assertTrue(is_double($response['data'][0]['lat']));
        $this->assertTrue(is_integer($response['data'][0]['course']));
        $this->assertTrue(is_integer($response['data'][0]['heading']));
        $this->assertTrue(is_string($response['data'][0]['rot']));
        $this->assertTrue(is_integer($response['data'][0]['timestamp']));
    }

    public function testInvalidVesselIdShouldReturnNotFound() {
        $response = $this->get('/api/positions/9999999999999999999999999999999');
        
        $response->assertStatus(404);
        $this->assertFalse($response['status']);
        $this->assertArrayNotHasKey('data', $response);
        $this->assertArrayHasKey('errorCode', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertTrue($response['errorCode'] == 'err01');
        $this->assertTrue($response['message'] != '');
    }

    public function testGetPositionsByLonLatRange() {
        $response = $this->get('/api/positions/41.75178,43.75178/13.26933,16.19508');
        
        $response->assertStatus(200);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['status']);
        $this->assertGreaterThan(0, count($response['data']));

        // Check if one of the position objects contain all the expected
        // properties that a position object should.
        $this->assertArrayHasKey('mmsi', $response['data'][0]);
        $this->assertArrayHasKey('status', $response['data'][0]);
        $this->assertArrayHasKey('stationid', $response['data'][0]);
        $this->assertArrayHasKey('speed', $response['data'][0]);
        $this->assertArrayHasKey('lon', $response['data'][0]);
        $this->assertArrayHasKey('lat', $response['data'][0]);
        $this->assertArrayHasKey('course', $response['data'][0]);
        $this->assertArrayHasKey('heading', $response['data'][0]);
        $this->assertArrayHasKey('rot', $response['data'][0]);
        $this->assertArrayHasKey('timestamp', $response['data'][0]);

        // Check the datatypes of all the properties of a position object.
        $this->assertTrue(is_integer($response['data'][0]['mmsi']));
        $this->assertTrue(is_integer($response['data'][0]['status']));
        $this->assertTrue(is_integer($response['data'][0]['stationid']));
        $this->assertTrue(is_integer($response['data'][0]['speed']));
        $this->assertTrue(is_double($response['data'][0]['lon']));
        $this->assertTrue(is_double($response['data'][0]['lat']));
        $this->assertTrue(is_integer($response['data'][0]['course']));
        $this->assertTrue(is_integer($response['data'][0]['heading']));
        $this->assertTrue(is_string($response['data'][0]['rot']));
        $this->assertTrue(is_integer($response['data'][0]['timestamp']));
    }

    public function testGetPositionsWithInvalidLonLatRangeShouldReturnNotFound() {
        $response = $this->get('/api/positions/13.26933,16.19508/41.75178,43.75178');
        
        $this->assertFalse($response['status']);
        $this->assertArrayNotHasKey('data', $response);
        $this->assertArrayHasKey('errorCode', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertTrue($response['errorCode'] == 'err01');
        $this->assertTrue($response['message'] != '');
    }

    public function testInvalidLonLatRangeParametersShouldReturnInvalidParameters() {
        // No comma separated latitude param
        $response = $this->get('/api/positions/13.2693316.19508/41.75178,43.75178');
        $this->assertFalse($response['status']);
        $this->assertArrayNotHasKey('data', $response);
        $this->assertArrayHasKey('errorCode', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertTrue($response['errorCode'] == 'err02');
        $this->assertTrue($response['message'] != '');

        // No to range of latitude param
        $response = $this->get('/api/positions/13.26933/41.75178,43.75178');
        $this->assertFalse($response['status']);
        $this->assertArrayNotHasKey('data', $response);
        $this->assertArrayHasKey('errorCode', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertTrue($response['errorCode'] == 'err02');
        $this->assertTrue($response['message'] != '');

        // No to range of latitude param and no from longitude parame (but keeping comma)
        $response = $this->get('/api/positions/13.26933/,43.75178');
        $this->assertFalse($response['status']);
        $this->assertArrayNotHasKey('data', $response);
        $this->assertArrayHasKey('errorCode', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertTrue($response['errorCode'] == 'err02');
        $this->assertTrue($response['message'] != '');
    }

    public function testGetPositionsByTimestampRange() {
        $response = $this->get('/api/positions?start=1372643960&end=1372673960');

        $response->assertStatus(200);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('data', $response);
        $this->assertTrue($response['status']);
        $this->assertGreaterThan(0, count($response['data']));

        // Check if one of the position objects contain all the expected
        // properties that a position object should.
        $this->assertArrayHasKey('mmsi', $response['data'][0]);
        $this->assertArrayHasKey('status', $response['data'][0]);
        $this->assertArrayHasKey('stationid', $response['data'][0]);
        $this->assertArrayHasKey('speed', $response['data'][0]);
        $this->assertArrayHasKey('lon', $response['data'][0]);
        $this->assertArrayHasKey('lat', $response['data'][0]);
        $this->assertArrayHasKey('course', $response['data'][0]);
        $this->assertArrayHasKey('heading', $response['data'][0]);
        $this->assertArrayHasKey('rot', $response['data'][0]);
        $this->assertArrayHasKey('timestamp', $response['data'][0]);

        // Check the datatypes of all the properties of a position object.
        $this->assertTrue(is_integer($response['data'][0]['mmsi']));
        $this->assertTrue(is_integer($response['data'][0]['status']));
        $this->assertTrue(is_integer($response['data'][0]['stationid']));
        $this->assertTrue(is_integer($response['data'][0]['speed']));
        $this->assertTrue(is_double($response['data'][0]['lon']));
        $this->assertTrue(is_double($response['data'][0]['lat']));
        $this->assertTrue(is_integer($response['data'][0]['course']));
        $this->assertTrue(is_integer($response['data'][0]['heading']));
        $this->assertTrue(is_string($response['data'][0]['rot']));
        $this->assertTrue(is_integer($response['data'][0]['timestamp']));
    }

    public function testMissingTimestampRangeParameterShouldReturnInvalidParameter() {
        $response = $this->get('/api/positions?start=1372643960');
        
        $response->assertStatus(400);
        $this->assertFalse($response['status']);
        $this->assertArrayNotHasKey('data', $response);
        $this->assertArrayHasKey('errorCode', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertTrue($response['errorCode'] == 'err02');
        $this->assertTrue($response['message'] != '');
    }

    public function testTimestampRangeContainsCharachtersShouldReturnInvalidParameter() {
        $response = $this->get('/api/positions?start=13726ds43960&end=1372sd343673aasa960');
        
        $response->assertStatus(400);
        $this->assertFalse($response['status']);
        $this->assertArrayNotHasKey('data', $response);
        $this->assertArrayHasKey('errorCode', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertTrue($response['errorCode'] == 'err02');
        $this->assertTrue($response['message'] != '');
    }

}
