<?php

namespace model\repositories;

use model\interfaces\dao\ILocationDAO;
use model\interfaces\repositories\ILocationRepository;
use config\DependencyInjector;

class LocationRepository extends BaseRepository implements ILocationRepository {
    
    public function __construct( ILocationDAO $locationDAO = null ) {
        if ( !isset( $locationDAO ) )
            $locationDAO = DependancyInjector::getContainer()['locationDAO'];

        parent::__construct( $locationDAO );
    }
}