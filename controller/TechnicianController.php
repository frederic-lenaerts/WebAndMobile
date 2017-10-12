<?php

namespace controller;

require_once( 'vendor/autoload.php' );

use model\Technician;
use model\interfaces\repositories\ITechnicianRepository;
use config\DependencyInjector;

class TechnicianController {

    public function __construct( ITechnicianRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['technicianRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {
        $statuscode = 200;
        $technicians = array();

        try {
            $technicians = $this->repository->findAll();
        } catch ( Exception $e ) {
            $statuscode=500;
        }

        $this->returnJSON( $technicians, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $technician = null;

        try {
            $technician = $this->repository->find( $id );

            if ( $technician == null ) {
                 $statuscode = 204;
            }
        } catch ( Exception $e ) {
            $statuscode = 500;
        }

        $this->returnJSON( $technician, $statuscode );
    }

    public function handleCreate( $technician ) {
        $createdTechnician = null;
        $statuscode = 201;

        if ( isset( $technician ) ) {
            try {
                $createdTechnician = $this->repository->create( $technician );

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