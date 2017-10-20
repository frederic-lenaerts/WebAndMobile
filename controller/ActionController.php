<?php

namespace controller;

use model\interfaces\repositories\IReportRepository;
use config\DependencyInjector;

class ActionController extends BaseController {

    public function __construct( IActionRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['actionRepository'];

        parent::__construct( $repository );
    }

    public function handleFindAll() {
        parent::handleFindAll();
    }

    public function handleFind( $id ) {
        parent::handleFind( $id );
    }

    public function handleCreate( $action ) {
        parent::handleCreate( $action );
    }
}