<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="animal")
 */
class Animal{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="animales")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Raza", inversedBy="animales")
     * @ORM\JoinColumn(name="raza_id", referencedColumnName="id")
     */
    private $raza;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice(){
        return $this->price;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge(){
        return $this->age;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture(){
        return $this->picture;
    }

    /**
     * Get usuario
     *
     * @return object
     */
    public function getUsuario(){
        return $this->usuario;
    }

    /**
     * Get raza
     *
     * @return object
     */
    public function getRaza(){
        return $this->raza;
    }

    /**
     * Set id
     *
     * @return void
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * Set name
     *
     * @return void
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * Set price
     *
     * @return void
     */
    public function setPrice($price){
        $this->price = $price;
    }

    /**
     * Set description
     *
     * @return void
     */
    public function setDescription($description){
        $this->description = $description;
    }

     /**
     * Set age
     *
     * @return void
     */
    public function setAge($age){
        $this->age = $age;
    }

    /**
     * Set picture
     *
     * @return void
     */
    public function setPicture($picture){
        $this->picture = $picture;
    }

    /**
     * Set usuario
     *
     * @return void
     */
    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

    /**
     * Set raza
     *
     * @return void
     */
    public function setRaza($raza){
        $this->raza = $raza;
    }
}