<?php

namespace controller;

use model\interfaces\repositories\ILocationRepository;
use config\DependencyInjector;

class LocationController extends BaseController {

    public function __construct( ILocationRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['locationRepository'];

        parent::__construct( $repository );
    }
}