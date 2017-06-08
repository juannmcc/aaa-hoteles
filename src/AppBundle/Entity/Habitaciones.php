<?php

namespace AppBundle\Entity;

/**
 * Habitaciones
 */
class Habitaciones
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $planta;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Tipohabs
     */
    private $idtipohab;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Habitaciones
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
     * Set planta
     *
     * @param integer $planta
     *
     * @return Habitaciones
     */
    public function setPlanta($planta)
    {
        $this->planta = $planta;

        return $this;
    }

    /**
     * Get planta
     *
     * @return integer
     */
    public function getPlanta()
    {
        return $this->planta;
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
     * Set idtipohab
     *
     * @param \AppBundle\Entity\Tipohabs $idtipohab
     *
     * @return Habitaciones
     */
    public function setIdtipohab(\AppBundle\Entity\Tipohabs $idtipohab = null)
    {
        $this->idtipohab = $idtipohab;

        return $this;
    }

    /**
     * Get idtipohab
     *
     * @return \AppBundle\Entity\Tipohabs
     */
    public function getIdtipohab()
    {
        return $this->idtipohab;
    }
    /**
     * @var \AppBundle\Entity\Hoteles
     */
    private $idhotel;


    /**
     * Set idhotel
     *
     * @param \AppBundle\Entity\Hoteles $idhotel
     *
     * @return Habitaciones
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

    public function __toString() {
        $nameinclude = "";
        if ($this->nombre != "") $nameinclude = " (".$nameinclude.")";
        return 'Hab nº'.$this->id.$nameinclude;
    }
}
