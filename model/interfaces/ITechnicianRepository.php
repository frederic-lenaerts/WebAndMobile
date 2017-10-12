<?php

namespace model\interfaces;

interface ITechnicianRepository extends IDAO {

    public function create( $name, $location_id );
    public function update( $id, $name, $location_id );
    public function delete( $id );
}