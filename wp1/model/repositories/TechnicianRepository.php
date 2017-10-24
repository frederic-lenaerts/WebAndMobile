<?php

namespace model\repositories;

use model\interfaces\dao\ITechnicianDAO;
use model\interfaces\repositories\ITechnicianRepository;
use config\DependencyInjector;

class TechnicianRepository extends BaseRepository implements ITechnicianRepository {

    public function __construct( ITechnicianDAO $technicianDAO = null ) {
        if ( !isset( $technicianDAO ) )
            $technicianDAO = DependancyInjector::getContainer()['technicianDAO'];

        parent::__construct( $technicianDAO );
    }
}