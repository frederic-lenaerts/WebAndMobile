<?php

namespace model;

class Status implements \JsonSerializable {
    
    private $id;
	private $location_id;
	private $status;
	private $date;

    function __construct( $location_id, $status, $date, $id = null ) {
        $this->setId( $id );
        $this->setLocationId( $location_id );
        $this->setStatus( $status );
        $this->setDate( $date );
        //$this->setHandled( $handled );
        //$this->setTechnicianId( $technician_id );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setLocationId( $location_id ) {
        $this->location_id = $location_id;
    }
    
    public function setStatus( $status ) {
        $this->status = $status;
    }

    public function setDate( $date ) {
        $this->date = $date;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getLocationId() {
        return $this->location_id;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function getDate() {
        return $this->date;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'location_id' => $this->getLocationId(),
            'handled' => $this->getStatus(),
            'date' => $this->getDate()
        ];
    }
}