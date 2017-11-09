<?php

namespace tests\model\repositories;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Action;
use model\Location;
use model\dao\ActionDAO;
use model\repositories\ActionRepository;
use tests\util\GUID;

class ActionRepositoryTests extends TestCase {

    public function setUp() {
        $this->actionDAOMock = $this->getMockBuilder('\model\dao\ActionDAO')
                                ->disableOriginalConstructor()
                                ->getMock();
        $this->actionRepository = new ActionRepository( $this->actionDAOMock );
    }

    public function tearDown() {
        $this->actionDAOMock = null;
        $this->actionRepository = null;
    }

    public function testFind_IdExists_ActionObject() {
        //Arrange
        $action = $this->createAction();
        $this->actionDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'find' )
                            ->with( $action->getId() )
                            ->will( $this->returnValue( $action ));
        //Act
        $actualAction = $this->actionRepository->find( $action->getId() );
        //Assert
        $this->assertEquals( $action, $actualAction );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        $id = rand();
        $this->actionDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'find' )
                            ->with( $id )
                            ->will( $this->returnValue( null ));
        //Act
        $result = $this->actionRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFind_invalidId_Null() {
        $id = GUID::create();
        $this->actionDAOMock->expects( $this->never() )
                            ->method( 'find' );
        //Act
        $result = $this->actionRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFindAll_MultipleActionsExist_ActionObjectArray() {
        //Arrange
        $actions = array();
        $actions[0] = $this->createAction();
        $actions[1] = $this->createAction();
        $this->actionDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'findAll' )
                            ->will( $this->returnValue( $actions ));
        //Act
        $actualActions = $this->actionRepository->findAll();
        //Assert
        $this->assertEquals( sort( $actions ), sort( $actualActions ));
    }

    public function testCreate_ValidActionObjectWithoutIdProvided_ActionObjectWithId() {
        //Arrange
        $actionWithId = $this->createAction();
        $action = clone $actionWithId;
        $action->setId( null );
        $this->actionDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'create' )
                            ->with( $action )
                            ->will( $this->returnValue( $actionWithId ));
        //Act
        $createdAction = $this->actionRepository->create( $action );
        //Assert
        $this->assertNotNull( $createdAction->getId() );
        $this->assertEquals( $action->getAction(), $createdAction->getAction() );
        $this->assertEquals( $action->getDate(), $createdAction->getDate() );
    }

    public function testFind_emptyActionObject_Null() {
        $this->actionDAOMock->expects( $this->never() )
                            ->method( 'create' );
        //Act
        $result = $this->actionRepository->create( null );
        //Assert
        $this->assertNull( $result );
    }

    private function createAction() {
        $text = GUID::create();
        $dateArray = getdate();
        $date = $dateArray['year'].'-'.$dateArray['mon'].'-'.$dateArray['mday'];
        $id = rand();
        $location = new Location( GUID::create(), rand() );
        return new Action( $text, $date, $location, $id );
    }
}