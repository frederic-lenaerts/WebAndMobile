<?php

namespace model\repositories;

use model\interfaces\dao\IReportDAO;
use model\interfaces\repositories\IReportRepository;
use config\DependencyInjector;

class ReportRepository extends BaseRepository implements IReportRepository {
    
    public function __construct( IReportDAO $reportDAO = null) {
        if ( !isset( $reportDAO ) )
            $reportDAO = DependancyInjector::getContainer()['reportDAO'];

        parent::__construct( $reportDAO );
    }
}