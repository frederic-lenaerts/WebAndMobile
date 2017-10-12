<?php

namespace model\factories;

use model\Status;

abstract class StatusFactory {
    public static function CreateFromArray( $array ) {
        return new Status(
            $array['location_id'],
            $array['status'],
            $array['date'],
            $array['id']
        );
    }
}