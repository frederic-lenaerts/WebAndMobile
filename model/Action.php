<?php

namespace model;

class Action implements JsonSerializable {

    private $id;
    private $action;
    private $date;

    public function __construct( $id, $action, $date ) {
        $this->setId( $id );
        $this->setAction( $action );
        $this->setDate( $date );
    }

    public function setId( $id ) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setAction( $action ) {
        $this->action = $action;
    }

    public function getAction() {
        return $this->action;
    }

    public function setDate( $date ) {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'action' => $this->getAction(),
            'date' => $this->getDate()
        ];
    }
}