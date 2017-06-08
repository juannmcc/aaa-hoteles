<?php

namespace AppBundle\Entity;

/**
 * Hoteles
 */
class Hoteles
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $categoria = '3';

    /**
     * @var integer
     */
    private $telefono;

    /**
     * @var string
     */
    private $email;

        /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $localizacion;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Hoteles
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Hoteles
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Set categoria
     *
     * @param integer $categoria
     *
     * @return Hoteles
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return integer
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     *
     * @return Hoteles
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Hoteles
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set localizacion
     *
     * @param string $localizacion
     *
     * @return Hoteles
     */
    public function setLocalizacion($localizacion)
    {
        $this->localizacion = $localizacion;

        return $this;
    }

    /**
     * Get localizacion
     *
     * @return string
     */
    public function getLocalizacion()
    {
        return $this->localizacion;
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
        return 'Hotel '.$this->nombre;
    }
}
