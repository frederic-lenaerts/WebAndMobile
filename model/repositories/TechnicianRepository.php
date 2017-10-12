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

    public function create( $technician ) {
        $createdTechnician = null;

        if ( isset( $technician ) )
            $createdTechnician = $this->technicianDAO->create( $technician );

        return $createdTechnician;
    }
    
    private function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;

        return is_integer( $id ) && $id >= 0;
    }
}