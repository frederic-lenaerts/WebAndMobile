<?php

namespace model\interfaces\repositories;

interface IReportRepository {

    public function findAll();
    public function find( $id );
    public function create( $report );
}