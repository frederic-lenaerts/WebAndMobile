<?php

namespace model\repositories;

use model\Status;
use model\dao\StatusDAO;
use model\interfaces\dao\IStatusDAO;
use model\interfaces\repositories\IStatusRepository;
use config\DependencyInjector;

class StatusRepository implements IStatusRepository{

    public function __construct( IStatusDAO $statusDAO = null ) {
        if ( !isset( $statusDAO ) )
            $statusDAO = DependancyInjector::getContainer()['actionDAO'];

        $this->actionDAO = $statusDAO;
    }

    public function findAll() {
        $status = $this->actionDAO->findAll();

        return $status;
    }

    public function find( $id ) {
        $status = null;

        if ( $this->isValidId( $id ) )
            $status = $this->actionDAO->find( $id );
                
        return $status;
    }

    public function create( $status ) {
        $createdAction = null;

        if ( isset( $status ) )
            $createdAction = $this->actionDAO->create( $status );

        return $createdAction;
    }
    
    private function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;
            
        return is_integer( $id ) && $id >= 0;
    }
}