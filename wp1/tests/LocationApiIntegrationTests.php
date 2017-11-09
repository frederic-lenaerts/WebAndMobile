<?php

namespace tests;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;

class LocationApiIntegrationTests extends TestCase {

    public function setUp() {
        $this->http = new \GuzzleHttp\Client(['base_uri' => 'http://192.168.2.250/wp1/']);
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testGET_AllLocations() {
        //Arrange
        //Act
        $response = $this->http->request('GET', 'location/');
        //Assert
        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testGET_LocationById() {
        //Arrange
        //Act
        $response = $this->http->request('GET', 'location/1');
        //Assert
        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }
}