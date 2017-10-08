<?php

namespace model\interfaces;

interface IActionRepository {

    public function findAll();
    public function find( $id );
    public function create( $action, $date );
    public function update( $id, $action, $date );
    public function delete( $id );
}