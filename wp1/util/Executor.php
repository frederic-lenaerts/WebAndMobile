<?php

namespace util;

use PDOException;

class Executor {

    public static function tryPDO( $query, $connection ) {
        try {
            return $query;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }

    public function try( $function ) {
        try {
            return $function;
        } catch ( Exception $e ) {
            return $e->getMessage();
        }
    }
}