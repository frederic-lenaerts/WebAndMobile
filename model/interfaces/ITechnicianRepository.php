<?php

namespace model\interfaces;

interface ITechnicianRepository {

    public function findAll();
    public function find( $id );
    public function create( $name, $location_id );
    public function update( $id, $name, $location_id );
    public function delete( $id );
}