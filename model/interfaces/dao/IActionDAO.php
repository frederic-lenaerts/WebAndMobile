<?php

namespace model\interfaces\dao;

interface IActionDAO {

    public function findAll();
    public function find( $id );
    public function create( $action );
}