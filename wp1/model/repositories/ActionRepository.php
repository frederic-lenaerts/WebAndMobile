<?php

namespace model\repositories;

use model\interfaces\dao\IActionDAO;
use model\interfaces\repositories\IActionRepository;
use config\DependencyInjector;

class ActionRepository extends BaseRepository implements IActionRepository{

    public function __construct( IActionDAO $actionDAO = null ) {
        if ( !isset( $actionDAO ) )
            $actionDAO = DependancyInjector::getContainer()['actionDAO'];

        parent::__construct( $actionDAO );
    }
}