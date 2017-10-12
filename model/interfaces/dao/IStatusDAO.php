<?php

namespace model\interfaces\dao;

interface IStatusDAO {

    public function findAll();
    public function find( $id );
    public function create( $location_id, $status, $date );
}