<?php

namespace model;

class Report implements \JsonSerializable
{
    private $id;
	private $location_id;
	private $date;
	private $handled;
	private $technician_id;

    function __construct( $id, $location_id, $date, $handled, $technician_id = null ) {
        $this->setId( $id );
        $this->setLocationId( $location_id );
        $this->setDate( $date );
        $this->setHandled( $handled );
        $this->setTechnicianId( $technician_id );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setLocationId( $location_id ) {
        $this->location_id = $location_id;
    }

    public function setDate( $date ) {
        $this->date = $date;
    }

    public function setHandled( $handled ) {
        $this->handled = $handled;
    }

    public function setTechnicianId( $technician_id ) {
        $this->technician_id = $technician_id;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getLocationId() {
        return $this->location_id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getHandled() {
        return $this->handled;
    }

    public function getTechnicianId() {
        return $this->technician_id;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'location_id' => $this->getLocationId(),
            'date' => $this->getDate(),
            'handled' => $this->getHandled(),
            'technician_id' => $this->getTechnicianId()
        ];
    }
}