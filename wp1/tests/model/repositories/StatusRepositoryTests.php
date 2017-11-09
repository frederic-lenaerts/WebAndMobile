<?php

namespace tests\model\repositories;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Status;
use model\Location;
use model\dao\StatusDAO;
use model\repositories\StatusRepository;
use tests\util\GUID;

class StatusRepositoryTests extends TestCase {

    public function setUp() {
        $this->statusDAOMock = $this->getMockBuilder('\model\dao\StatusDAO')
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->statusRepository = new StatusRepository( $this->statusDAOMock );
    }

    public function tearDown() {
        $this->statusDAOMock = null;
        $this->statusRepository = null;
    }

    public function testFind_IdExists_StatusObject() {
        //Arrange
        $status = $this->createStatus();
        $this->statusDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'find' )
                            ->with( $status->getId() )
                            ->will( $this->returnValue( $status ));
        //Act
        $actualStatus = $this->statusRepository->find( $status->getId() );
        //Assert
        $this->assertEquals( $status, $actualStatus );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        $id = rand();
        $this->statusDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'find' )
                            ->with( $id )
                            ->will( $this->returnValue( null ));
        //Act
        $result = $this->statusRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFind_invalidId_Null() {
        $id = GUID::create();
        $this->statusDAOMock->expects( $this->never() )
                            ->method( 'find' );
        //Act
        $result = $this->statusRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFindAll_MultipleStatusExist_StatusObjectArray() {
        //Arrange
        $status = array();
        $status[0] = $this->createStatus();
        $status[1] = $this->createStatus();
        $this->statusDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'findAll' )
                            ->will( $this->returnValue( $status ));
        //Act
        $actualstatus = $this->statusRepository->findAll();
        //Assert
        $this->assertEquals( sort( $status ), sort( $actualstatus ));
    }

    public function testCreate_ValidStatusObjectWithoutIdProvided_StatusObjectWithId() {
        //Arrange
        $statusWithId = $this->createStatus();
        $status = clone $statusWithId;
        $status->setId( null );
        $this->statusDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'create' )
                            ->with( $status )
                            ->will( $this->returnValue( $statusWithId ));
        //Act
        $createdStatus = $this->statusRepository->create( $status );
        //Assert
        $this->assertNotNull( $createdStatus->getId() );
        $this->assertEquals( $status->getStatusAsString(), $createdStatus->getStatusAsString() );
        $this->assertEquals( $status->getDate(), $createdStatus->getDate() );
    }

    public function testFind_emptyStatusObject_Null() {
        $this->statusDAOMock->expects( $this->never() )
                            ->method( 'create' );
        //Act
        $result = $this->statusRepository->create( null );
        //Assert
        $this->assertNull( $result );
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