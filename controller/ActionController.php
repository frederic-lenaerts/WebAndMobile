<?php

namespace controller;

require_once('vendor/autoload.php');

use model\Action;
use model\interfaces\IActionRepository;

class ActionController {

    private $repository;

    public function __construct( IActionRepository $repository ) {
        $this->repository = $repository;
    }

    public function handleFindAll() {
        $action = $this->repository->findAll();
        echo json_encode( $action );
    }
}