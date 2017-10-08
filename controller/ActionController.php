<?php

namespace controller;

require_once('vendor/autoload.php');

use model\Action;
use model\interfaces\IActionRepository;
use config\DependencyInjector;

class ActionController {

    private $repository;

    public function __construct( IActionRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['actionRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {
        $action = $this->repository->findAll();
        echo json_encode( $action );
    }
}