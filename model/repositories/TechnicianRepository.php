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
        $technicians = $this->technicianDAO->findAll();

        return $technicians;
    }

    public function find( $id ) {
        $technician = null;

        if ( $this->isValidId( $id ) )
                $technician = $this->technicianDAO->find( $id );

        return $technician;
    }

    public function create( $name, $location_id ) {
        $createdTechnician = null;

        if ( isset( $technician ) )
            $createdTechnician = $this->technicianDAO->create( $technician );

        return $createdTechnician;
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