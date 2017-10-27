<?php

namespace model;

class Status implements \JsonSerializable {
    
    private $id;
	private $status;
    private $date;
    private $location;
    private $statusArray = array( 0 => "niet goed", 1 => "middelmatig", 2 => "goed" );

    function __construct( $status, $date, $location = null, $id = null ) {
        $this->setId( $id );
        $this->setStatus( $status );
        $this->setDate( $date );
        $this->setLocation( $location );
        //$this->setHandled( $handled );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }
    
    public function setStatus( $status ) {
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

    public function getStatusString() {
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
            'status' => $this->getStatusString(),
            'location' => $this->getLocation()
        ];
    }
}

abstract class StatusTypes {
    const NietGoed = "niet goed";

}