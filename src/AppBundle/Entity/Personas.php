<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Personas
 */
class Personas
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellidos;

    /**
     * @var integer
     */
    private $idcliente;

    /**
     * @var integer
     */
    private $dni;

    /**
     * @var \Doctrine\Common\Collections\Collection|Registro[] 
     */
    private $idregistro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idregistro = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Personas
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Personas
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set idcliente
     *
     * @param integer $idcliente
     *
     * @return Personas
     */
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;

        return $this;
    }

    /**
     * Get idcliente
     *
     * @return integer
     */
    public function getIdcliente()
    {
        return $this->idcliente;
    }

    /**
     * Get dni
     *
     * @return integer
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Add idregistro
     *
     * @param \AppBundle\Entity\Registros $idregistro
     *
     * @return Personas
     */
    public function addIdregistro(\AppBundle\Entity\Registros $idregistro)
    {
        $this->idregistro[] = $idregistro;

        return $this;
    }

    /**
     * Remove idregistro
     *
     * @param \AppBundle\Entity\Registros $idregistro
     */
    public function removeIdregistro(\AppBundle\Entity\Registros $idregistro)
    {
        $this->idregistro->removeElement($idregistro);
    }

    /**
     * Get idregistro
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdregistro()
    {
        return $this->idregistro;
    }
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString() {
        return $this->nombre.' '.$this->apellidos;
    }
}
