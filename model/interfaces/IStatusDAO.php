<?php

namespace model\interfaces;

interface IStatusDAO extends IDAO {

    public function create( $location_id, $status, $date );
    /*
    public function update( $id, $location_id, $status, $date );
    public function delete( $id );
    */
}