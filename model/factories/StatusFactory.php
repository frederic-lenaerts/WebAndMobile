<?php

namespace model\factories;

use model\Status;

abstract class StatusFactory {
    public static function CreateFromArray( $array ) {
        return new Status(
            $data['location_id'],
            $data['status'],
            $data['date'],
            $data['id']
        );
    }
}