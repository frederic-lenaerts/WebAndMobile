<?php

namespace controller;

require_once('vendor/autoload.php');

use model\Action;
use model\interfaces\IActionRepository;
use config\DependencyInjector;

class ActionController {

    public function __construct( IActionRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['actionRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {

        $statuscode = 200;
        $actions = array();
        try {
            $actions = $this->repository->findAll();
        } catch (Exception $e) {
            $statuscode=500;
        }
        $this->returnJSON( $actions, $statuscode );
        /*
        $actions = $this->repository->findAll();
        header('Content-Type: application/json');
        http_response_code($statuscode);
        echo json_encode( $actions );
        */
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $action = null;
        try {
            $action = $this->repository->find( $id );
            if ( $action == null ) {
                 $statuscode = 204;
            }
        } catch (Exception $e) {
            $statuscode = 500;
        }
        $this->returnJSON( $action, $statuscode );
    }

    public function handleCreate( $action ) {
        $createdAction = null;
        if ( isset( $action )) {
            $this->repository->create( $action );
        }
    }

    private function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}