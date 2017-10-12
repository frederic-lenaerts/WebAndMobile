<?php

namespace model\repositories;

use model\Report;
use model\dao\ReportDAO;
use model\interfaces\dao\IReportDAO;
use model\interfaces\repositories\IReportRepositories;
use config\DependencyInjector;

class ReportRepository implements IReportRepositories {
    
    public function __construct( IReportDAO $reportDAO = null) {
        if ( !isset( $reportDAO ) )
            $reportDAO = DependancyInjector::getContainer()['reportDAO'];

        $this->reportDAO = $reportDAO;
    }

    public function findAll() {
        $reports = $this->reportDAO->findAll();
        return $reports;
    }

    public function find( $id ) {
        $report = null;
        if ($this->isValidId($id)) {
                $report = $this->reportDAO->find( $id );
        }
        return $report;
    }

    public function create( $report ) {
        $createdReport = null;
        if ( isset( $report )) {
            $createdReport = $this->reportDAO->create( $report );
        }
        return $createdReport;
    }
    
    private function isValidId( $id )
    {
        if ( is_string( $id ) && ctype_digit( trim( $id ))) {
            $id = (int) $id;
        }
        return is_integer( $id ) && $id >= 0;
    }
}