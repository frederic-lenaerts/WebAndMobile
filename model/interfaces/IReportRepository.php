<?php

namespace model\interfaces;

interface IReportRepository extends IDAO {

    public function create( $location_id, $date, $handled, $technician_id );
    public function update( $id, $location_id, $date, $handled, $technician_id );
    public function delete( $id );
}