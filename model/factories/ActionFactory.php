<?php

namespace model\factories;

use model\Action;

abstract class ActionFactory {
    public static function CreateFromArray( $array ) {
        return new Action(
            $array['action'], 
            $array['date'], 
            $array['id'] );
    }
}