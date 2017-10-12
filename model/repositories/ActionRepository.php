<?php

namespace model\repositories;

use model\Action;
use model\dao\ActionDAO;
use model\interfaces\dao\IActionDAO;
use model\interfaces\repositories\IActionRepository;
use config\DependencyInjector;

class ActionRepository implements IActionRepository{

    public function __construct( IActionDAO $actionDAO = null ) {
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

        if ( $this->isValidId( $id ) )
            $action = $this->actionDAO->find( $id );
                
        return $action;
    }

    public function create( $action ) {
        $createdAction = null;

        if ( isset( $action ) )
            $createdAction = $this->actionDAO->create( $action );
            
        return $createdAction;
    }
    
    private function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;

        return is_integer( $id ) && $id >= 0;
    }
}