<?php

namespace model\interfaces\deao;

interface ITechnicianDAO {

    public function findAll();
    public function find( $id );
    public function create( $technician );
}