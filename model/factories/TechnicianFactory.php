<?php

namespace model\factories;

use model\Technician;

abstract class TechnicianFactory {
    public static function CreateFromArray( $array ) {
        return new Technician(
            $data['name'],
            $data['location_id'],
            $data['id']
        );
    }
}