<?php

namespace model\factories;

use model\Report;

abstract class ReportFactory {
    public static function CreateFromArray( $array ) {
        if ( !array_key_exists( 'id', $array ) ) {
            $array['id'] = null;
        }

        if ( !array_key_exists( 'technician_id', $array ) ) {
            $array['technician_id'] = null;
        }
        
        return new Report(
            $array['location_id'], 
            $array['date'], 
            $array['handled'],
            $array['technician_id'],
            $array['id']
        );
    }
}