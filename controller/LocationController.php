<?php

namespace controller;

require_once( 'vendor/autoload.php' );

use model\Location;
use model\interfaces\repostories\ILocationRepository;
use config\DependencyInjector;

class LocationController implements ILocationRepository {

    public function __construct( ILocationRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['locationRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {
        $statuscode = 200;
        $locations = array();

        try {
            $locations = $this->repository->findAll();
        } catch ( Exception $e ) {
            $statuscode=500;
        }

        $this->returnJSON( $locations, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $location = null;

        try {
            $location = $this->repository->find( $id );

            if ( $location == null ) {
                    $statuscode = 204;
            }
        } catch ( Exception $e ) {
            $statuscode = 500;
        }

        $this->returnJSON( $location, $statuscode );
    }

    public function handleCreate( $location ) {
        $createdTechnician = null;
        $statuscode = 201;

        if ( isset( $location ) ) {
            try {
                $createdTechnician = $this->repository->create( $location );

                if ( !isset( $createdTechnician ) ) {
                    $statuscode = 500;
                }
            } catch ( Exception $e ) {
                $statuscode = 500;
            }   
        } else {
            $statuscode = 400;
        }

        $this->returnJSON( $createdTechnician, $statuscode );
    }

    private function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}