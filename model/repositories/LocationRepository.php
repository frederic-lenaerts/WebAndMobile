<?php

namespace model\repositories;

use \PDO;
use PDOException;
use model\interfaces\ILocationRepository;
use model\Location;
use config\DependencyInjector;

class LocationRepository implements ILocationRepository {
    
    private $connection = null;

    public function __construct( PDO $connection ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['locationDAO'];

        $this->connection = $connection;
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