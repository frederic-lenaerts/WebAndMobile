<?php

namespace model\interfaces\repositories;

interface ITechnicianRepository {

    public function findAll();
    public function find( $id );
    public function create( $technician );
}