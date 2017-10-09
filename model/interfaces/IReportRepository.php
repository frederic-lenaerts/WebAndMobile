<?php

namespace model\interfaces;

interface IReportRepository {

    public function findAll();
    public function find( $id );
    public function create( $location_id, $date, $handled, $technician_id );
    public function update( $id, $location_id, $date, $handled, $technician_id );
    public function delete( $id );
}