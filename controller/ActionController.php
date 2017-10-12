<?php

namespace controller;

use model\interfaces\repositories\IReportRepository;
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
        } catch ( Exception $e ) {
            $statuscode=500;
        }

        $this->returnJSON( $actions, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $action = null;

        try {
            $action = $this->repository->find( $id );
            if ( $action == null ) {
                 $statuscode = 204;
            }
        } catch ( Exception $e ) {
            $statuscode = 500;
        }

        $this->returnJSON( $action, $statuscode );
    }

    public function handleCreate( $action ) {
        $createdAction = null;
        $statuscode = 201;

        if ( isset( $action ) ) {
            try {
                $createdAction = $this->repository->create( $action );
                if ( !isset( $createdAction ) ) {
                    $statuscode = 500;
                }
            } catch ( Exception $e ) {
                $statuscode = 500;
            }   
        } else {
            $statuscode = 400;
        }
        
        $this->returnJSON( $createdAction, $statuscode );
    }

    private function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}