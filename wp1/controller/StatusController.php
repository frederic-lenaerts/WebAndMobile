<?php

namespace controller;

use model\interfaces\repositories\IStatusRepository;
use config\DependencyInjector;

class StatusController extends BaseController {
    
    public function __construct( IStatusRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['statusRepository'];

        parent::__construct( $repository );
    }
}