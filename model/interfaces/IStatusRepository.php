<?php

namespace model\interfaces;

interface IStatusRepository {

    public function findAll();
    public function find( $id );
    public function create( $location_id, $status, $date );
    public function update( $id, $location_id, $status, $date );
    public function delete( $id );
}