<?php

namespace controller;

use model\interfaces\repositories\IReportRepository;
use config\DependencyInjector;

class ReportController extends BaseController {

    public function __construct( IReportRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['reportRepository'];

        parent::__construct( $repository );
    }
}