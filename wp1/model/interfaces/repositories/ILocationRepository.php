<?php

namespace model\interfaces\repositories;

interface ILocationRepository {

    public function findAll();
    public function find( $id );
    public function create( $location );
}