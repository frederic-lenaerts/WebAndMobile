<?php

namespace tests\model\repositories;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Technician;
use model\Location;
use model\dao\TechnicianDAO;
use model\repositories\TechnicianRepository;
use tests\util\GUID;

class TechnicianRepositoryTests extends TestCase {

    public function setUp() {
        $this->technicianDAOMock = $this->getMockBuilder('\model\dao\TechnicianDAO')
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->technicianRepository = new TechnicianRepository( $this->technicianDAOMock );
    }

    public function tearDown() {
        $this->technicianDAOMock = null;
        $this->technicianRepository = null;
    }

    public function testFind_IdExists_TechnicianObject() {
        //Arrange
        $technician = $this->createTechnician();
        $this->technicianDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'find' )
                            ->with( $technician->getId() )
                            ->will( $this->returnValue( $technician ));
        //Act
        $actualTechnician = $this->technicianRepository->find( $technician->getId() );
        //Assert
        $this->assertEquals( $technician, $actualTechnician );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        $id = rand();
        $this->technicianDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'find' )
                            ->with( $id )
                            ->will( $this->returnValue( null ));
        //Act
        $result = $this->technicianRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFind_invalidId_Null() {
        $id = GUID::create();
        $this->technicianDAOMock->expects( $this->never() )
                            ->method( 'find' );
        //Act
        $result = $this->technicianRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFindAll_MultipleTechnicianExist_TechnicianObjectArray() {
        //Arrange
        $technician = array();
        $technician[0] = $this->createTechnician();
        $technician[1] = $this->createTechnician();
        $this->technicianDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'findAll' )
                            ->will( $this->returnValue( $technician ));
        //Act
        $actualTechnician = $this->technicianRepository->findAll();
        //Assert
        $this->assertEquals( sort( $technician ), sort( $actualTechnician ));
    }

    public function testCreate_ValidTechnicianObjectWithoutIdProvided_TechnicianObjectWithId() {
        //Arrange
        $technicianWithId = $this->createTechnician();
        $technician = clone $technicianWithId;
        $technician->setId( null );
        $this->technicianDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'create' )
                            ->with( $technician )
                            ->will( $this->returnValue( $technicianWithId ));
        //Act
        $createdTechnician = $this->technicianRepository->create( $technician );
        //Assert
        $this->assertNotNull( $createdTechnician->getId() );
        $this->assertEquals( $technician->getTechnicianAsString(), $createdTechnician->getTechnicianAsString() );
        $this->assertEquals( $technician->getDate(), $createdTechnician->getDate() );
    }

    public function testFind_emptyTechnicianObject_Null() {
        $this->technicianDAOMock->expects( $this->never() )
                            ->method( 'create' );
        //Act
        $result = $this->technicianRepository->create( null );
        //Assert
        $this->assertNull( $result );
    }

    private function createTechnician() {
        $id = rand();
        $name = GUID::create();
        $location = new Location( GUID::create(), rand() );
        return new Technician( $name, $location, $id );
    }
}