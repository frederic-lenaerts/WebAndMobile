<?php

namespace tests;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Location;
use model\Status;
use tests\util\GUID;

class StatusApiIntegrationTests extends TestCase {

    public function setUp() {
        $this->http = new \GuzzleHttp\Client( ['base_uri' => 'http://192.168.2.250/wp1/'] );
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testGET_AllStatus_200() {
        //Arrange
        //Act
        $response = $this->http->request( 'GET', 'status/' );
        //Assert
        $this->assertEquals( 200, $response->getStatusCode() );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals( "application/json", $contentType );
    }

    public function testGET_StatusById_Exists_200() {
        //Arrange
        //Act
        $response = $this->http->request( 'GET', 'status/1' );
        //Assert
        $this->assertEquals( 200, $response->getStatusCode() );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals( "application/json", $contentType );
    }

    public function testGET_StatusById_DoesNotExist_204() {
        //Arrange
        //Act
        $response = $this->http->request( 'GET', 'status/'.PHP_INT_MAX );
        //Assert
        $this->assertEquals( 204, $response->getStatusCode() );
    }

    public function testPOST_Status_ValidStatusObject_201() {
        //Arrange
        $status = $this->createStatus();
        //Act
        $response = $this->http->request( 'POST', 'status/', [
            "Content-Type" => "application/json",
            "body" => \json_encode( $status )
        ]);
        //Assert
        $this->assertEquals( 201, $response->getStatusCode() );
    }

    public function testPOST_Status_NullObject_400() {
        //Arrange
        //Act
        $response = $this->http->request( 'POST', 'status/', [
            "Content-Type" => "application/json",
            "http_errors" => false,
            "body" => null
        ]);
        //Assert
        $this->assertEquals( 400, $response->getStatusCode() );
    }

    public function testPOST_Status_BadJSON_400() {
        //Arrange
        $json = "{\"".GUID::create()."\": \"".GUID::create()."\"}";
        //Act
        $response = $this->http->request( 'POST', 'status/', [
            "Content-Type" => "application/json",
            "http_errors" => false,
            "body" => $json
        ]);
        //Assert
        $this->assertEquals( 400, $response->getStatusCode() );
    }

    private function createStatus() {
        $dateArray = getdate();
        $date = $dateArray['year'].'-'.$dateArray['mon'].'-'.$dateArray['mday'];
        $location = new Location( GUID::create(), rand() );
        $status = rand(0, 2);
        return new Status( $status, $date, $location );
    }
}