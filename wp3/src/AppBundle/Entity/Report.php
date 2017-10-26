<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Location;
use Symfony\Component\HttpFoundation\Request;

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
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    private $location;

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

    public function setLocationId( $locationId ) {
        $this->locationId = $locationId;
    }

    public function setDate( $date ) {
        $this->date = $date;
    }

    public function setHandled( $handled ) {
        $this->handled = $handled;
    }

    public function setTechnicianId( $technicianId ) {
        $this->technicianId = $technicianId;
    }
    
    public function setLocation( $locationId ) {
        $this->location = $location;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getLocationId() {
        return $this->locationId;
    }

    public function getDate() {
        return $this->date;
    }

    public function getHandled() {
        return ( $this->handled ) ? 'Handled' : 'Not handled';
    }

    public function getTechnicianId() {
        return $this->technicianId;
    }

    public function getLocation() {
        return $this->location;
    }
}