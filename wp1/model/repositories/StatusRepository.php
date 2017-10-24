<?php

namespace model\repositories;

use model\interfaces\dao\IStatusDAO;
use model\interfaces\repositories\IStatusRepository;
use config\DependencyInjector;

class StatusRepository extends BaseRepository implements IStatusRepository{

    public function __construct( IStatusDAO $statusDAO = null ) {
        if ( !isset( $statusDAO ) )
            $statusDAO = DependancyInjector::getContainer()['statusDAO'];

        parent::__construct( $statusDAO );
    }
}