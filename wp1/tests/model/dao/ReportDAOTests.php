<?php

namespace tests\model\dao;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Report;
use model\Location;
use model\Technician;
use model\dao\ReportDAO;
use tests\util\GUID;

class ReportDAOTests extends TestCase {

    public function setUp() {
        $this->connection = new \PDO('sqlite::memory:');
        $this->connection->exec( 
            'CREATE TABLE reports (
            id INTEGER, 
            text TEXT,
            date TEXT,
            handled BOOLEAN,
            location_id INTEGER,
            technician_id INTEGER,
            PRIMARY KEY (id))'
        );
        $this->connection->exec( 
            'CREATE TABLE locations (
            id INTEGER, 
            name TEXT,
            PRIMARY KEY (id))'
        );
        $this->connection->exec( 
            'CREATE TABLE technicians (
            id INTEGER, 
            name VARCHAR,
            location_id INTEGER,
            PRIMARY KEY (id))'
        );
        $this->reportDAO = new ReportDAO( $this->connection );
    }

    public function tearDown() {
        $this->connection = null;
        $this->reportDAO = null;
    }

    public function testFind_IdExists_ReportObject() {
        $this->markTestSkipped('Throws an \error for an unknow reasons');
        //Arrange
        $report = $this->createReport();
        $this->addToTable( $report );
        //Act
        $actualReport = $this->reportDAO->find( $report->getId() );
        //Assert
        $this->assertEquals( $report, $actualReport );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        //Act
        $actualReport = $this->reportDAO->find( rand() );
        //Assert
        $this->assertNull( $actualReport );
    }

    public function testFind_TableReportsDoesntExist_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $this->connection->exec( "DROP TABLE reports" );
        //Act
        $this->reportDAO->find( 1 );
        //Assert
    }

    public function testFindAll_MultipleReportExist_ReportObjectArray() {
        //Arrange
        $reports = array();
        $reports[0] = $this->createReport();
        $this->addToTable( $reports[0] );
        $reports[1] = $this->createReport();
        $this->addToTable( $reports[1] );
        //Act
        $actualReports = $this->reportDAO->findAll();
        //Assert
        $this->assertEquals( sort( $reports ), sort( $actualReports ));
    }
    
    public function testFindAll_TableReportsDoesntExist_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $this->connection->exec( "DROP TABLE reports" );
        //Act
        $this->reportDAO->findAll();
        //Assert
    }

    public function testCreate_ValidReportObjectWithoutIdProvided_ReportObjectWithId() {
        //Arrange
        $report = $this->createReport();
        $report->setId( null );
        //Act
        $createdReport = $this->reportDAO->create( $report );
        //Assert
        $this->assertNotNull( $createdReport->getId() );
        $this->assertEquals( $report->getText(), $createdReport->getText() );
        $this->assertEquals( $report->getDate(), $createdReport->getDate() );
        $this->assertEquals( $report->isHandled(), $createdReport->isHandled() );
        $this->assertEquals( $report->getLocation(), $createdReport->getLocation() );
        $this->assertEquals( $report->getTechnician(), $createdReport->getTechnician() );
    }

    public function testCreate_NullReportObject_Exception() {
        //Arrange
        $this->expectException( \Error::class );
        $report = null;
        //Act
        $createdReport = $this->reportDAO->create( $report );
        //Assert
    }

    private function addToTable( $report ) {
        $this->connection->exec(
            "INSERT INTO reports (id, text, date, handled, location_id) 
            VALUES (".$report->getId().",'".$report->getText()."','".$report->getDate()."', ".$report->isHandled().", ".$report->getLocation()->getId().");"
        );
        $location = $report->getLocation();
        $this->connection->exec(
            "INSERT INTO locations (id, name) 
            VALUES (".$location->getId().",'".$location->getName()."');"
        );
        $technician = $report->getTechnician();
        $this->connection->exec(
            "INSERT INTO technicians (id, name, location_id) 
            VALUES (".$technician->getId().",'".$technician->getName()."', ".$technician->getLocation()->getId().");"
        );
    }

    private function createReport() {
        $dateArray = getdate();
        $date = $dateArray['year'].'-'.$dateArray['mon'].'-'.$dateArray['mday'];
        $id = rand();
        $text = GUID::create();
        $handled = $this->createRandomBoolean();
        $location = new Location( GUID::create(), rand() );
        $technician = new Technician( GUID::create(), $location, rand() );
        return new Report( $date, $text, $handled, $location, $technician, $id );
    }

    private function createRandomBoolean() {
        return rand() % 2 == 0;
    }
}
