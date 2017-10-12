<?php

namespace model\factories;

use model\Technician;

abstract class TechnicianFactory {
    public static function CreateFromArray( $array ) {
        if ( !array_key_exists( 'id', $array ) ) {
            $array['id'] = null;
        }
        
        return new Technician(
            $array['name'],
            $array['location_id'],
            $array['id']
        );
    }
}