<?php

namespace model\factories;

use model\Status;

abstract class StatusFactory {
    public static function CreateFromArray( $array ) {
        if ( !array_key_exists( 'id', $array ) ) {
            $array['id'] = null;
        }
        
        return new Status(
            $array['location_id'],
            $array['status'],
            $array['date'],
            $array['id']
        );
    }
}