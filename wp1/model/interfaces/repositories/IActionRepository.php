<?php

namespace model\interfaces\repositories;

interface IActionRepository {

    public function findAll();
    public function find( $id );
    public function create( $action );
}