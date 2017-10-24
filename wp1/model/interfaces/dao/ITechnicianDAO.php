<?php

namespace model\interfaces\dao;

interface ITechnicianDAO {

    public function findAll();
    public function find( $id );
    public function create( $technician );
}