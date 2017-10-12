<?php

namespace model\repositories;

use model\Technician;
use model\dao\TechnicianDAO;
use model\interfaces\dao\ITechnicianDAO;
use model\interfaces\repositories\ITechnicianRepository;
use config\DependencyInjector;

class TechnicianRepository implements ITechnicianRepository {

    public function __construct( ITechnicianDAO $technicianDAO = null ) {
        if ( !isset( $technicianDAO ) )
            $technicianDAO = DependancyInjector::getContainer()['technicianDAO'];

        $this->technicianDAO = $technicianDAO;
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