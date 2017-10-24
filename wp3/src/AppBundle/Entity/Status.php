<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="status", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Status
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_id", type="integer", nullable=false)
     */
    private $locationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;


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
}