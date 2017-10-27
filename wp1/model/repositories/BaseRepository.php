<?php

namespace model\repositories;

abstract class BaseRepository {

    public function __construct( $DAO ) {
        $this->DAO = $DAO;
    }

    public function findAll() {
        $results = $this->DAO->findAll();

        return $results;
    }

    public function find( $id ) {
        $result = null;
        
        if ( $this->isValidId( $id ) )
            $result = $this->DAO->find( $id );
                
        return $result;
    }

    public function create( $object ) {
        $createdResult = null;

        if ( isset( $object ) )
            $createdResult = $this->DAO->create( $object );
            
        return $createdResult;
    }
    
    protected function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;

        return is_integer( $id ) && $id >= 0;
    }
}