<?php

namespace model\repositories;

use model\Location;
use model\dao\LocationDAO;
use model\interfaces\dao\ILocationDAO;
use model\interfaces\repositories\ILocationRepository;
use config\DependencyInjector;

class LocationRepository implements ILocationRepository {
    
    public function __construct( ILocationDAO $locationDAO = null ) {
        if ( !isset( $locationDAO ) )
            $locationDAO = DependancyInjector::getContainer()['locationDAO'];

        $this->locationDAO = $locationDAO;
    }

    public function findAll() {
        $locations = $this->locationDAO->findAll();

        return $locations;
    }

    public function find( $id ) {
        $location = null;

        if ( $this->isValidId( $id ) )
            $location = $this->locationDAO->find( $id );

        return $location;
    }

    public function create( $location ) {
        $createdLocation = null;

        if ( isset( $location ) )
            $createdLocation = $this->locationDAO->create( $location );

        return $createdLocation;
    }
    
    private function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;

        return is_integer( $id ) && $id >= 0;
    }
}