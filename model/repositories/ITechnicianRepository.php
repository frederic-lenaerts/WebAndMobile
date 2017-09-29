<?php

namespace model;

interface ITechnicianRepository {

    public function getTechnicians();
    public function getTechnicianById( $id );
    public function createTechnician( $name, $location_id );
    public function updateTechnician( $id, $name, $location_id );
    public function deleteTechnician( $id );
}