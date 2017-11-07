<?php
namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="userName", type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="rolesString", type="string", length=255)
     */
    private $rolesstring;
    
    /**
     * @ORM\Column(name="technician_id", type="integer", nullable=true)
     */
    private $technician_id;

    //methodes uit UserInterface

    public function getUserName() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
    
    public function getTechnicianId() {
        return $this->technician_id;
    }

  	public function eraseCredentials() {
    }

   	public function getRoles() {
        return preg_split( "/[\s,]+/", $this->rolesstring );
    }

   	public function getSalt() {
    	return null;
    }

    //methodes uit Serializable

    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
	        $this->rolesstring
        ));
    }

    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->rolesstring
        ) = unserialize( $serialized );
    }

    //overblijvende getters /setters
    public function getId() {
        return $this->id;
    }

    public function setUserName( $username ) {
        $this->username = $username;

        return $this;
    }

    public function setPassword( $password ) {
        $this->password = $password;

        return $this;
    }

    public function setRolesString( $rolesstring ) {
        $this->rolesstring = $rolesstring;

        return $this;
    }

    public function setTechnicianId( $technician_id ) {
        $this->technician_id = $technician_id;

        return $this;
    }

    //toString
    public function __toString() {
        return "Entity User, username= " . $this->username;
    }
}