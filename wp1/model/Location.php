<?php

namespace model;

class Location implements \JsonSerializable {
    
    private $id;
	private $name;

    function __construct( $name, $id = null ) {
        $this->setId( $id );
        $this->setName( $name );
    }

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setName( $name ) {
        $this->name = $name;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
		return $this->name;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }
}