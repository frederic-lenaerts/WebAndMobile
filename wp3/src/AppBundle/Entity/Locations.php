<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Locations
 *
 * @ORM\Table(name="locations", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Locations
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
}