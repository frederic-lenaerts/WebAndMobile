<?php

namespace controller;

require_once( 'vendor/autoload.php' );

use model\Technician;
use model\interfaces\repostories\ITechnicianRepository;
use config\DependencyInjector;

class TechnicianController {

    public function __construct( ITechnicianRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['techinicianRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {
        $statuscode = 200;
        $techinicians = array();

        try {
            $techinicians = $this->repository->findAll();
        } catch ( Exception $e ) {
            $statuscode=500;
        }

        $this->returnJSON( $techinicians, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $techinician = null;

        try {
            $techinician = $this->repository->find( $id );

            if ( $techinician == null ) {
                 $statuscode = 204;
            }
        } catch ( Exception $e ) {
            $statuscode = 500;
        }

        $this->returnJSON( $techinician, $statuscode );
    }

    public function handleCreate( $techinician ) {
        $createdTechnician = null;
        $statuscode = 201;

        if ( isset( $techinician ) ) {
            try {
                $createdTechnician = $this->repository->create( $techinician );

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