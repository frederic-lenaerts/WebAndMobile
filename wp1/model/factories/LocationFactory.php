<?php

namespace model\factories;

use model\Location;

abstract class LocationFactory {
    public static function CreateFromArray( $array ) {
        if ( !array_key_exists( 'id', $array ) ) {
            $array['id'] = null;
        }
        
        return new Location(
            $array['name'],
            $array['id']
        );
    }
}