<?php

namespace tests\model\dao;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Technician;
use model\Location;
use model\dao\TechnicianDAO;
use tests\util\GUID;

class TechnicianDAOTests extends TestCase {

    public function setUp() {
        $this->connection = new \PDO('sqlite::memory:');
        $this->connection->exec( 
            'CREATE TABLE technicians (
            id INTEGER, 
            name varchar(45),
            location_id INTEGER,
            PRIMARY KEY (id))'
        );
        $this->connection->exec( 
            'CREATE TABLE locations (
            id INTEGER, 
            name TEXT,
            PRIMARY KEY (id))'
        );
        $this->technicianDAO = new TechnicianDAO($this->connection);
    }

    public function tearDown() {
        $this->connection = null;
    }

    public function testFind_IdExists_TechnicianObject() {
        //Arrange
        $technician = $this->createTechnician();
        $this->addToTable( $technician );
        //Act
        $actualTechnician = $this->technicianDAO->find( $technician->getId() );
        //Assert
        $this->assertEquals( $technician, $actualTechnician );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        //Act
        $actualTechnician = $this->technicianDAO->find( rand() );
        //Assert
        $this->assertNull( $actualTechnician );
    }

    public function testFind_TableTechnicianDoesntExist_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $this->connection->exec( "DROP TABLE technicians" );
        //Act
        $this->technicianDAO->find( 1 );
        //Assert
    }

    public function testFindAll_MultipleTechnicianExist_TechnicianObjectArray() {
        //Arrange
        $technician = array();
        $technician[0] = $this->createTechnician();
        $this->addToTable( $technician[0] );
        $technician[1] = $this->createTechnician();
        $this->addToTable( $technician[1] );
        //Act
        $actualTechnician = $this->technicianDAO->findAll();
        //Assert
        $this->assertEquals( sort( $technician ), sort( $actualTechnician ));
    }
    
    public function testFindAll_TableTechnicianDoesntExist_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $this->connection->exec( "DROP TABLE technicians" );
        //Act
        $this->technicianDAO->findAll();
        //Assert
    }

    public function testCreate_ValidTechnicianObjectWithoutIdProvided_TechnicianObjectWithId() {
        //Arrange
        $technician = $this->createTechnician();
        $technician->setId( null );
        //Act
        $createdTechnician = $this->technicianDAO->create( $technician );
        //Assert
        $this->assertNotNull( $createdTechnician->getId() );
        $this->assertEquals( $technician->getTechnicianAsString(), $createdTechnician->getTechnicianAsString() );
        $this->assertEquals( $technician->getDate(), $createdTechnician->getDate() );
    }

    public function testCreate_NullTechnicianObject_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $technician = null;
        //Act
        $createdTechnician = $this->technicianDAO->create( $technician );
        //Assert
    }

    private function addToTable( $technician ) {
        $this->connection->exec(
            "INSERT INTO technicians (id, name, location_id) 
            VALUES (".$technician->getId().",'".$technician->getName()."', ".$technician->getLocation()->getId().");"
        );
        $location = $technician->getLocation();
        $this->connection->exec(
            "INSERT INTO locations (id, name) 
            VALUES (".$location->getId().",'".$location->getName()."');"
        );
    }

    private function createTechnician() {
        $id = rand();
        $name = GUID::create();
        $location = new Location( GUID::create(), rand() );
        return new Technician( $name, $location, $id );
    }
}
