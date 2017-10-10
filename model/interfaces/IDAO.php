<?php 

namespace model\interfaces;

interface IDAO {
    public function findAll();
    public function find( $id );
}