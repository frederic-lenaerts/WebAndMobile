<?php

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Location;
use model\dao\LocationDAO;
use tests\util\GUID;

class LocationDAOTests extends TestCase {

    public function setUp() {
        $this->connection = new \PDO('sqlite::memory:');
        $this->connection->exec( 
            'CREATE TABLE locations (
            id INTEGER, 
            name TEXT,
            PRIMARY KEY (id))'
        );
    }

    public function tearDown() {
        $this->connection = null;
    }

    public function testFind_IdExists_ActionObject() {
        //Arrange
        $location = $this->createLocation();
        $this->addToTable( $location );
        $locationDAO = new LocationDAO($this->connection);
        //Act
        $actualAction = $locationDAO->find( $location->getId() );
        //Assert
        $this->assertEquals( $location, $actualAction );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        $locationDAO = new LocationDAO( $this->connection );
        //Act
        $actualAction = $locationDAO->find( rand() );
        //Assert
        $this->assertNull( $actualAction );
    }

    public function testFind_TableLocationsDoesntExist_Exception() {
        //Arrange
        $this->expectException( Error::class );
        $this->connection->exec( "DROP TABLE locations" );
        $locationDAO = new LocationDAO( $this->connection );
        //Act
        $locationDAO->find( 1 );
    }

    public function testFindAll_MultipleLocationsExist_ActionObjectArray() {
        //Arrange
        $locations = array();
        $locations[0] = $this->createLocation();
        $this->addToTable( $locations[0] );
        $locations[1] = $this->createLocation();
        $this->addToTable( $locations[1] );
        $locationDAO = new LocationDAO( $this->connection );
        //Act
        $actualLocations = $locationDAO->findAll();
        //Assert
        $this->assertEquals( sort( $locations ), sort( $actualLocations ));
    }
    
    public function testFindAll_TableLocationsDoesntExist_Exception() {
        //Arrange
        $this->expectException( Error::class );
        $this->connection->exec( "DROP TABLE locations" );
        $locationDAO = new LocationDAO( $this->connection );
        //Act
        $locationDAO->findAll();
    }

    public function testCreate_ValidActionObjectWithoutIdProvided_ActionObjectWithId() {
        //Arrange
        $location = $this->createLocation();
        $location->setId( null );
        $locationDAO = new LocationDAO( $this->connection );
        //Act
        $createdLocation = $locationDAO->create( $location );
        //Assert
        $this->assertNotNull( $createdLocation->getId() );
        $this->assertEquals( $location->getName(), $createdLocation->getName() );
    }

    public function testCreate_NullActionObject_Exception() {
        //Arrange
        $this->expectException( Error::class );
        $location = null;
        $locationDAO = new LocationDAO( $this->connection );
        //Act
        $createdLocation = $locationDAO->create( $location );
    }

    private function addToTable( $location ) {
        $this->connection->exec(
            "INSERT INTO locations (id, name) 
            VALUES (".$location->getId().",'".$location->getName()."');"
        );
    }

    private function createLocation() {
        $id = rand();
        $name = GUID::create();
        return new Location( $name, $id );
    }

}
