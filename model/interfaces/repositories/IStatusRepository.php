<?php

namespace model\interfaces\repositories;

interface IStatusRepository {

    public function findAll();
    public function find( $id );
    public function create( $location_id, $status, $date );
}