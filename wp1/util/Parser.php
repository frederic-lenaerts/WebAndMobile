<?php

namespace util;

abstract class Parser {
    public static function hasValidStatusKeys( $array ) {
        return $array && array_key_exists( "status", $array )
                      && array_key_exists( "date", $array )
                      && array_key_exists( "location", $array )
                      && self::hasValidLocationKeysWithId( $array["location"] );
    }

    public static function hasValidLocationKeys ( $array ) {
        return $array && array_key_exists( "name", $array );
    }

    private static function hasValidLocationKeysWithId( $array ) {
        return $array && array_key_exists( "name", $array )
                      && array_key_exists( "id", $array );
    }

    public static function hasValidReportKeys( $array ) {
        return $array && array_key_exists( "text", $array )
                      && array_key_exists( "date", $array )
                      && array_key_exists( "handled", $array )
                      && array_key_exists( "location", $array )
                      && self::hasValidLocationKeysWithId( $array["location"] )
                      && array_key_exists( "technician", $array );
    }

    public static function hasValidActionKeys( $array ) {
        return $array && array_key_exists( "date", $array )
                      && array_key_exists( "action", $array )
                      && array_key_exists( "location", $array )
                      && self::hasValidLocationKeysWithId( $array["location"] );
    }

    public static function hasValidTechnicianKeys( $array ) {
        return $array && array_key_exists( "name ", $array )
                      && array_key_exists( "location", $array )
                      && self::hasValidLocationKeysWithId( $array["location"] );
    }
}