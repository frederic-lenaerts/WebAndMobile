<?php

namespace model\interfaces\repositories;

interface IStatusRepository {

    public function findAll();
    public function find( $id );
    public function create( $status );
}