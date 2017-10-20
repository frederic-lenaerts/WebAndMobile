<?php

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Action;
use model\dao\ActionDAO;

class ActionDAOTests extends TestCase {

    public function setUp() {
        $this->connection = new \PDO('sqlite::memory:');
        $this->connection->exec('CREATE TABLE actions (
                        id INTEGER, 
                        action TEXT,
                        date TEXT,
                        PRIMARY KEY (id))');
    }

    public function tearDown() {
        $this->connection = null;
    }

    public function testFind_IdExists_ActionObject() {
        //Arrange
        $action = $this->createAction();
        $this->connection->exec(
            "INSERT INTO actions (id, action, date) 
            VALUES (".$action->getId().",'".$action->getAction()."','".$action->getDate()."');");
        $actionDAO = new ActionDAO($this->connection);
        //Act
        $actualAction = $actionDAO->find( $action->getId() );
        //Assert
        $this->assertEquals($action, $actualAction);
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        $action = $this->createAction();
        $actionDAO=new ActionDAO($this->connection);
        //Act
        $actualAction = $actionDAO->find($action->id);
        //Assert
        $this->assertNull($actualAction);
    }

    public function testFind_TableActionsDoesntExist_Exception() {
        //Arrange
        $this->expectException(Error::class);
        $this->connection->exec("DROP TABLE actions");
        $actionDAO = new ActionDAO($this->connection);
        //Act
        $actionDAO->find(1);
    }

    public function testFindAll_MultipleActionsExist_ActionObjectArray() {
        //Arrange
        $actions = array();
        $actions[0] = $action = $this->createAction();
        $this->connection->exec(
            "INSERT INTO actions (id, action, date) 
            VALUES (".$actions[0]->getId().",'".$actions[0]->getAction()."','".$actions[0]->getDate()."');");
        $actions[1] = $action = $this->createAction();
        $this->connection->exec(
            "INSERT INTO actions (id, action, date) 
            VALUES (".$actions[1]->getId().",'".$actions[1]->getAction()."','".$actions[1]->getDate()."');");
        $actionDAO = new ActionDAO($this->connection);
        //Act
        $actualActions = $actionDAO->findAll();
        //Assert
        $this->assertEquals( sort($actions), sort($actualActions) );
    }
    
    public function testFindAll_TableActionsDoesntExist_Exception() {
        //Arrange
        $this->expectException(Error::class);
        $this->connection->exec("DROP TABLE actions");
        $actionDAO = new ActionDAO($this->connection);
        //Act
        $actionDAO->findAll();
    }

    public function testCreate_ValidActionObjectWithoutIdProvided_ActionObjectWithId() {
        //Arrange
        $action = $this->createAction();
        $action->setId( null );
        $actionDAO = new ActionDAO($this->connection);
        //Act
        $createdAction = $actionDAO->create( $action );
        //Assert
        $this->assertNotNull( $createdAction->getId() );
        $this->assertEquals( $action->getAction(), $createdAction->getAction() );
        $this->assertEquals( $action->getDate(), $createdAction->getDate() );
    }

    public function testCreate_NullActionObject_Exception() {
        //Arrange
        $this->expectException(Error::class);
        $action = null;
        $actionDAO = new ActionDAO($this->connection);
        //Act
        $createdAction = $actionDAO->create( $action );
    }

    private function createAction() {
        $actionString = $this->getGUID();
        $dateArray = getdate();
        $date = $dateArray['year'].'-'.$dateArray['mon'].'-'.$dateArray['mday'];
        $id = rand();
        return new Action( $actionString, $date, $id );
    }

    private function getGUID() {
        // Windows
        if (function_exists('com_create_guid') === true) {
            if ($trim === true)
                return trim(com_create_guid(), '{}');
            else
                return com_create_guid();
        }

        // OSX/Linux
        if (function_exists('openssl_random_pseudo_bytes') === true) {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

        // Fallback (PHP 4.2+)
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);                  // "-"
        $lbrace = $trim ? "" : chr(123);    // "{"
        $rbrace = $trim ? "" : chr(125);    // "}"
        $guidv4 = $lbrace.
                substr($charid,  0,  8).$hyphen.
                substr($charid,  8,  4).$hyphen.
                substr($charid, 12,  4).$hyphen.
                substr($charid, 16,  4).$hyphen.
                substr($charid, 20, 12).
                $rbrace;
        return $guidv4;
    }
}
