<?php

namespace AppBundle\Entity;

/**
 * Tipohabs
 */
class Tipohabs
{
    /**
     * @var string
     */
    private $tipohab;

    /**
     * @var float
     */
    private $preciobase;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set tipohab
     *
     * @param string $tipohab
     *
     * @return Tipohabs
     */
    public function setTipohab($tipohab)
    {
        $this->tipohab = $tipohab;

        return $this;
    }

    /**
     * Get tipohab
     *
     * @return string
     */
    public function getTipohab()
    {
        return $this->tipohab;
    }

    /**
     * Set preciobase
     *
     * @param float $preciobase
     *
     * @return Tipohabs
     */
    public function setPreciobase($preciobase)
    {
        $this->preciobase = $preciobase;

        return $this;
    }

    /**
     * Get preciobase
     *
     * @return float
     */
    public function getPreciobase()
    {
        return $this->preciobase;
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

    public function __toString() {
        return $this->id.' - '.$this->tipohab.' ( '.$this->preciobase.' € )';
    }
}
