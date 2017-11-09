<?php

namespace tests\model\repositories;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Location;
use model\dao\LocationDAO;
use model\repositories\LocationRepository;
use tests\util\GUID;

class LocationRepositoryTests extends TestCase {

    public function setUp() {
        $this->locationDAOMock = $this->getMockBuilder('\model\dao\LocationDAO')
                                      ->disableOriginalConstructor()
                                      ->getMock();
        $this->locationRepository = new LocationRepository( $this->locationDAOMock );
    }

    public function tearDown() {
        $this->locationDAOMock = null;
        $this->locationRepository = null;
    }

    public function testFind_IdExists_LocationObject() {
        //Arrange
        $location = $this->createLocation();
        $this->locationDAOMock->expects( $this->atLeastOnce() )
                              ->method( 'find' )
                              ->with( $location->getId() )
                              ->will( $this->returnValue( $location ));
        //Act
        $actualAction = $this->locationRepository->find( $location->getId() );
        //Assert
        $this->assertEquals( $location, $actualAction );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        $id = rand();
        $this->locationDAOMock->expects( $this->atLeastOnce() )
                              ->method( 'find' )
                              ->with( $id )
                              ->will( $this->returnValue( null ));
        //Act
        $result = $this->locationRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFind_invalidId_Null() {
        $id = GUID::create();
        $this->locationDAOMock->expects( $this->never() )
                              ->method( 'find' );
        //Act
        $result = $this->locationRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFindAll_MultipleLocationsExist_LocationObjectArray() {
        //Arrange
        $locations = array();
        $locations[0] = $this->createLocation();
        $locations[1] = $this->createLocation();
        $this->locationDAOMock->expects( $this->atLeastOnce() )
                              ->method( 'findAll' )
                              ->will( $this->returnValue( $locations ));
        //Act
        $actuallocations = $this->locationRepository->findAll();
        //Assert
        $this->assertEquals( sort( $locations ), sort( $actuallocations ));
    }

    public function testCreate_ValidLocationObjectWithoutIdProvided_LocationObjectWithId() {
        //Arrange
        $locationWithId = $this->createLocation();
        $location = clone $locationWithId;
        $location->setId( null );
        $this->locationDAOMock->expects( $this->atLeastOnce() )
                              ->method( 'create' )
                              ->with( $location )
                              ->will( $this->returnValue( $locationWithId ));
        //Act
        $createLocation = $this->locationRepository->create( $location );
        //Assert
        $this->assertNotNull( $createLocation->getId() );
        $this->assertEquals( $location->getName(), $createLocation->getName() );
    }

    public function testFind_emptyLocationObject_Null() {
        $this->locationDAOMock->expects( $this->never() )
                              ->method( 'create' );
        //Act
        $result = $this->locationRepository->create( null );
        //Assert
        $this->assertNull( $result );
    }

    private function createLocation() {
        $id = rand();
        $name = GUID::create();
        return new Location( $name, $id );
    }
}