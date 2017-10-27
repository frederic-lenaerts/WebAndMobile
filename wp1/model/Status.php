<?php

namespace model;

class Status implements \JsonSerializable {
    
    private $id;
	private $status;
    private $date;
    private $location;
    private $statusArray = array( 0 => "niet goed", "niet goed" => 0, 1 => "middelmatig", "middelmatig" => 1, 2 => "goed", "goed" => 2 );

    function __construct( $status, $date, $location = null, $id = null ) {
        $this->setId( $id );
        $this->setStatus( $status );
        $this->setDate( $date );
        $this->setLocation( $location );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }
    
    public function setStatus( $status ) {
        if ( \is_string( $status )) {
            $status = $this->statusArray[ $status ];
        }
        $this->status = $status;
    }

    public function setDate( $date ) {
        $this->date = $date;
    }

    public function setLocation ( Location $location ){
        $this->location = $location;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function getStatusAsString() {
        return $this->statusArray[$this->status];
    }

    public function getDate() {
        return $this->date;
    }

    public function getLocation() {
        return $this->location;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'date' => $this->getDate(),
            'status' => $this->getStatusAsString(),
            'location' => $this->getLocation()
        ];
    }
}

abstract class StatusTypes {
    const NietGoed = "niet goed";

}