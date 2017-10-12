<?php

namespace model\factories;

use model\Status;

abstract class StatusFactory {
    public static function CreateFromArray( $array ) {
        return new Status(
            $data['id'],
            $data['location_id'],
            $data['status'],
            $data['date']
        );
    }
}