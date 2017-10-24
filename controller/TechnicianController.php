<?php

namespace controller;

use model\interfaces\repositories\ITechnicianRepository;
use config\DependencyInjector;

class TechnicianController extends BaseController {

    public function __construct( ITechnicianRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['technicianRepository'];

        parent::__construct( $repository );
    }
}