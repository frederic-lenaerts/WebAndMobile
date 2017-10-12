<?php

namespace controller;

require_once('vendor/autoload.php');

use model\report;
use model\interfaces\repostories\IReportRepository;
use config\DependencyInjector;

class reportController {

    public function __construct( IReportRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['reportRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {
        $statuscode = 200;
        $reports = array();
        try {
            $reports = $this->repository->findAll();
        } catch (Exception $e) {
            $statuscode=500;
        }
        $this->returnJSON( $reports, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $report = null;
        try {
            $report = $this->repository->find( $id );
            if ( $report == null ) {
                 $statuscode = 204;
            }
        } catch (Exception $e) {
            $statuscode = 500;
        }
        $this->returnJSON( $report, $statuscode );
    }

    public function handleCreate( $report ) {
        $createdReport = null;
        $statuscode = 201;
        if ( isset( $report )) {
            try {
                $createdReport = $this->repository->create( $report );
                if ( !isset( $createdReport )) {
                    $statuscode = 500;
                }
            } catch (Exception $e) {
                $statuscode = 500;
            }   
        }
        else {
            $statuscode = 400;
        }
        $this->returnJSON( $createdReport, $statuscode );
    }

    private function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}