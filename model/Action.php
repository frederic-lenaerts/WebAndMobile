<?php

namespace model;

class Action implements \JsonSerializable {

    public function __construct( $action, $date, $id = null ) {
        if ($id !== null) {
            $this->setId( $id );
        }
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

    public static function deserialize( $data ) {
        return new self( 
            $data['action'], 
            $data['date'], 
            $data['id'] 
        );
    }
}
