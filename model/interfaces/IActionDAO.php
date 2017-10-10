<?php

namespace model\interfaces;

interface IActionDAO extends IDAO {

    
    public function create( $action );
    /*
    public function update( $id, $action, $date );
    public function delete( $id );
    */
}