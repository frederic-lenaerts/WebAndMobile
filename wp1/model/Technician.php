<?php

namespace model;

class Technician implements \JsonSerializable {
    
    private $id;
    private $name;
    private $location;

    function __construct( $name, $location, $id = null ) {
        $this->setId( $id );
        $this->setName( $name );
        $this->setLocation( $location );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setName( $name ) {
        $this->name = $name;
    }
    
    public function setLocation( $location ) {
        $this->location = $location;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
		return $this->name;
    }
    
    public function getLocation() {
        return $this->location;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'location' => $this->getLocation()
        ];
    }
}