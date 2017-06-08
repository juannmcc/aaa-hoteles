<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Registros
 */
class Registros
{
    /**
     * @var \DateTime
     */
    private $fechaentrada;

    /**
     * @var \DateTime
     */
    private $fechasalida;

    /**
     * @var boolean
     */
    private $estapagado;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Habitaciones
     */
    private $idhabitacion;

    /**
     * @var \AppBundle\Entity\Hoteles
     */
    private $idhotel;

    /**
     * @var \Doctrine\Common\Collections\Collection|Personas[]
     */
    private $idpersona;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idpersona = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set fechaentrada
     *
     * @param \DateTime $fechaentrada
     *
     * @return Registros
     */
    public function setFechaentrada($fechaentrada)
    {
        $this->fechaentrada = $fechaentrada;

        return $this;
    }

    /**
     * Get fechaentrada
     *
     * @return \DateTime
     */
    public function getFechaentrada()
    {
        return $this->fechaentrada;
    }

    /**
     * Set fechasalida
     *
     * @param \DateTime $fechasalida
     *
     * @return Registros
     */
    public function setFechasalida($fechasalida)
    {
        $this->fechasalida = $fechasalida;

        return $this;
    }

    /**
     * Get fechasalida
     *
     * @return \DateTime
     */
    public function getFechasalida()
    {
        return $this->fechasalida;
    }

    /**
     * Set estapagado
     *
     * @param boolean $estapagado
     *
     * @return Registros
     */
    public function setEstapagado($estapagado)
    {
        $this->estapagado = $estapagado;

        return $this;
    }

    /**
     * Get estapagado
     *
     * @return boolean
     */
    public function getEstapagado()
    {
        return $this->estapagado;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idhabitacion
     *
     * @param \AppBundle\Entity\Habitaciones $idhabitacion
     *
     * @return Registros
     */
    public function setIdhabitacion(\AppBundle\Entity\Habitaciones $idhabitacion = null)
    {
        $this->idhabitacion = $idhabitacion;
        //$idhabitacion->setRegistro($this);

        return $this;
    }

    /**
     * Get idhabitacion
     *
     * @return \AppBundle\Entity\Habitaciones
     */
    public function getIdhabitacion()
    {
        return $this->idhabitacion;
    }

    /**
     * Set idhotel
     *
     * @param \AppBundle\Entity\Hoteles $idhotel
     *
     * @return Registros
     */
    public function setIdhotel(\AppBundle\Entity\Hoteles $idhotel = null)
    {
        $this->idhotel = $idhotel;

        return $this;
    }

    /**
     * Get idhotel
     *
     * @return \AppBundle\Entity\Hoteles
     */
    public function getIdhotel()
    {
        return $this->idhotel;
    }

    /**
     * Add idpersona
     *
     * @param \AppBundle\Entity\Personas $idpersona
     *
     * @return Registros
     */
    public function addIdpersona(\AppBundle\Entity\Personas $idpersona)
    {
        $this->idpersona[] = $idpersona;

        return $this;
    }

    /**
     * Remove idpersona
     *
     * @param \AppBundle\Entity\Personas $idpersona
     */
    public function removeIdpersona(\AppBundle\Entity\Personas $idpersona)
    {
        $this->idpersona->removeElement($idpersona);
    }

    /**
     * Get idpersona
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdpersona()
    {
        return $this->idpersona;
    }


}
