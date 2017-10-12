<?php

namespace model\interfaces\dao;

interface ILocationDAO {

    public function findAll();
    public function find( $id );
    public function create( $location );
}