<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technician
 *
 * @ORM\Table(name="technicians", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="location_id", columns={"location_id"})})
 * @ORM\Entity
 */
class Technician
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;
    
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

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    // Setters
    public function setId( $id ) {
        $this->id = $id;
    }

    public function setName( $name ) {
        $this->name = $name;
    }
    
    public function setLocationId( $locationId ) {
        $this->locationId = $locationId;
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
    
    public function getLocationId() {
        return $this->locationId;
    }
    
    public function getLocation() {
        return $this->location;
    }
}