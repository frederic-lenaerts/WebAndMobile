<?php

namespace model;

class Tecnnician implements \JsonSerializable {
    
    private $id;
    private $name;
    private $location_id;

    function __construct( $id, $name, $location_id ) {
        $this->setId( $id );
        $this->setName( $name );
        $this->setLocationId( $location_id );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setName( $name ) {
        $this->name = $name;
    }
    
    public function setLocationId( $location_id ) {
        $this->location_id = $location_id;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
		return $this->name;
    }
    
    public function getLocationId() {
        return $this->location_id;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'location_id' => $this->getLocationId()
        ];
    }
    
}