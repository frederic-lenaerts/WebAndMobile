<?php

namespace model\factories;

use model\Location;

abstract class LocationFactory {
    public static function CreateFromArray( $array ) {
        return new Location(
            $data['name'],
            $data['id']
        );
    }
}