<?php

namespace model\factories;

use model\Action;

abstract class ActionFactory {
    public static function CreateFromArray( $array ) {
        if ( !array_key_exists( 'id', $array ) ) {
            $array['id'] = null;
        }
        
        return new Action(
            $array['action'],
            $array['date'],
            $array['id']
        );
    }
}