<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="status", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="location_id", columns={"location_id"})})
 * @ORM\Entity
 */
class Status
{
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

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Location
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="location_id", type="integer", nullable=true)
     */
    private $locationId;

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setLocationId( $locationId ) {
        $this->locationId = $locationId;
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
        return $this->locationId;
    }
    
    public function getLocation() {
        return $this->location;
    }
    
    public function getStatus( $readable = false ) {
        if ( $readable )
            switch ( $this->status ) {
                case 0: return 'Bad';
                case 1: return 'Average';
                case 2: return 'Good';
                default: return 'Unknown';
            }
        else
            return $this->status;
    }

    public function getDate() {
        return $this->date;
    }
}