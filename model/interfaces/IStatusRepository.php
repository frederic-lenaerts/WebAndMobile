<?php

namespace model\interfaces;

interface IStatusRepository {

    public function findAll();
    public function find( $id );
    public function create( $action, $date );
}