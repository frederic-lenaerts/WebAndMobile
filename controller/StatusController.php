<?php

namespace controller;

require_once( 'vendor/autoload.php' );

use model\Status;
use model\interfaces\repositories\IStatusRepository;
use config\DependencyInjector;

class StatusController {
    
    public function __construct( IStatusRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['statusRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {
        $statuscode = 200;
        $status = array();

        try {
            $status = $this->repository->findAll();
        } catch ( Exception $e ) {
            $statuscode=500;
        }

        $this->returnJSON( $status, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $status = null;

        try {
            $status = $this->repository->find( $id );

            if ( $status == null ) {
                    $statuscode = 204;
            }
        } catch ( Exception $e ) {
            $statuscode = 500;
        }

        $this->returnJSON( $status, $statuscode );
    }

    public function handleCreate( $status ) {
        $createdStatus = null;
        $statuscode = 201;

        if ( isset( $status ) ) {
            try {
                $createdStatus = $this->repository->create( $status );

                if ( !isset( $createdStatus ) ) {
                    $statuscode = 500;
                }
            } catch ( Exception $e ) {
                $statuscode = 500;
            }   
        } else {
            $statuscode = 400;
        }

        $this->returnJSON( $createdStatus, $statuscode );
    }

    private function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}