<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table(name="reports", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Report
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="handled", type="boolean", nullable=false)
     */
    private $handled = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="technician_id", type="integer", nullable=true)
     */
    private $technicianId;
    
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
}