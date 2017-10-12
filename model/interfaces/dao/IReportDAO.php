<?php

namespace model\interfaces\dao;

interface IReportDAO {

    public function findAll();
    public function find( $id );
    public function create( $location );
}