<?php

namespace model\factories;

use model\Technician;

abstract class TechnicianFactory {
    public static function CreateFromArray( $array ) {
        return new Technician(
            $array['name'],
            $array['location_id'],
            $array['id']
        );
    }
}