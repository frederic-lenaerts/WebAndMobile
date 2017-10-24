<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technicians
 *
 * @ORM\Table(name="technicians", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Technicians
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="location_id", type="integer", nullable=false)
     */
    private $locationId;

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
}