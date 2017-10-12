<?php

namespace model\repositories;

use \PDO;
use PDOException;
use model\interfaces\ITechnicianRepository;
use model\Technician;
use config\DependencyInjector;

class TechnicianRepository implements ITechnicianRepository {
    
    private $connection = null;

    public function __construct( PDO $connection ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['technicianDAO'];

        $this->connection = $connection;
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

    public function create( $name, $location_id ) {
        return $this->actionDAO->create( $action );
    }

    public function update( $id, $name, $location_id ) {
        
    }

    public function delete( $id ) {
        
    }
    
    private function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;

        return is_integer( $id ) && $id >= 0;
    }
}