<?php

namespace model\repositories;

require_once('vendor/autoload.php');

use model\Action;
use model\dao\ActionDAO;
use model\interfaces\IActionDAO;
use config\DependencyInjector;

class ActionRepository implements IActionDAO {

    public function __construct( ActionDAO $actionDAO = null) {
        if ( !isset( $actionDAO ) )
            $actionDAO = DependancyInjector::getContainer()['actionDAO'];

        $this->actionDAO = $actionDAO;
    }

    public function findAll() {
        $actions = $this->actionDAO->findAll();
        return $actions;
    }

    public function find( $id ) {
        $action = null;
        if ($this->isValidId($id)) {
                $action = $this->actionDAO->find( $id );
        }
        return $action;
    }

    public function create( $action ) {
        return $this->actionDAO->create( $action );
    }

    public function update( $id, $action, $date ) {
        
    }

    public function delete( $id ) {

    }

    private function isValidId( $id )
    {
        if ( is_string( $id ) && ctype_digit( trim( $id ))) {
            $id = (int) $id;
        }
        return is_integer( $id ) && $id >= 0;
    }
}