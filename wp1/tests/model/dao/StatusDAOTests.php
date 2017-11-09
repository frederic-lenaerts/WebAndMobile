<?php

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Status;
use model\Location;
use model\dao\StatusDAO;
use tests\util\GUID;

class StatusDAOTests extends TestCase {

    public function setUp() {
        $this->connection = new \PDO('sqlite::memory:');
        $this->connection->exec( 
            'CREATE TABLE status (
            id INTEGER, 
            status INTEGER,
            date TEXT,
            location_id INTEGER,
            PRIMARY KEY (id))'
        );
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

    public function testFind_IdExists_StatusObject() {
        //Arrange
        $status = $this->createStatus();
        $this->addToTable( $status );
        $statusDAO = new StatusDAO($this->connection);
        //Act
        $actualStatus = $statusDAO->find( $status->getId() );
        //Assert
        $this->assertEquals( $status, $actualStatus );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        $statusDAO = new StatusDAO( $this->connection );
        //Act
        $actualStatus = $statusDAO->find( rand() );
        //Assert
        $this->assertNull( $actualStatus );
    }

    public function testFind_TableStatusDoesntExist_Exception() {
        //Arrange
        $this->expectException( Error::class );
        $this->connection->exec( "DROP TABLE status" );
        $statusDAO = new StatusDAO( $this->connection );
        //Act
        $statusDAO->find( 1 );
    }

    public function testFindAll_MultiplestatusExist_StatusObjectArray() {
        //Arrange
        $status = array();
        $status[0] = $this->createStatus();
        $this->addToTable( $status[0] );
        $status[1] = $this->createStatus();
        $this->addToTable( $status[1] );
        $statusDAO = new StatusDAO( $this->connection );
        //Act
        $actualStatus = $statusDAO->findAll();
        //Assert
        $this->assertEquals( sort( $status ), sort( $actualStatus ));
    }
    
    public function testFindAll_TableStatusDoesntExist_Exception() {
        //Arrange
        $this->expectException( Error::class );
        $this->connection->exec( "DROP TABLE status" );
        $statusDAO = new StatusDAO( $this->connection );
        //Act
        $statusDAO->findAll();
    }

    public function testCreate_ValidStatusObjectWithoutIdProvided_StatusObjectWithId() {
        //Arrange
        $status = $this->createStatus();
        $status->setId( null );
        $statusDAO = new StatusDAO( $this->connection );
        //Act
        $createdStatus = $statusDAO->create( $status );
        //Assert
        $this->assertNotNull( $createdStatus->getId() );
        $this->assertEquals( $status->getStatusAsString(), $createdStatus->getStatusAsString() );
        $this->assertEquals( $status->getDate(), $createdStatus->getDate() );
    }

    public function testCreate_NullStatusObject_Exception() {
        //Arrange
        $this->expectException( Error::class );
        $status = null;
        $statusDAO = new StatusDAO( $this->connection );
        //Act
        $createdStatus = $statusDAO->create( $status );
    }

    private function addToTable( $status ) {
        $this->connection->exec(
            "INSERT INTO status (id, status, date, location_id) 
            VALUES (".$status->getId().",'".$status->getStatus()."','".$status->getDate()."', ".$status->getLocation()->getId().");"
        );
        $location = $status->getLocation();
        $this->connection->exec(
            "INSERT INTO locations (id, name) 
            VALUES (".$location->getId().",'".$location->getName()."');"
        );
    }

    private function createStatus() {
        $dateArray = getdate();
        $date = $dateArray['year'].'-'.$dateArray['mon'].'-'.$dateArray['mday'];
        $id = rand();
        $location = new Location( GUID::create(), rand() );
        $status = rand(0, 2);
        return new Status( $status, $date, $location, $id );
    }

}
