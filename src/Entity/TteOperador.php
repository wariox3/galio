<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteOperadorRepository")
 */
class TteOperador
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_operador_pk", type="string", length=20)
     */
    private $codigoOperadorPk = 1;

    /**
     * @ORM\Column(type="blob", name="imagen", nullable=true)
     */
    private $imagen;

    /**
     * @ORM\Column(type="string", length=5, name="extension", nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="direccion", type="string", length=150, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="telefono", type="string", length=80, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", length=50, nullable=true)
     */
    private $numeroIdentificacion;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="operadorRel")
     */
    protected $usuariosOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="operadorRel")
     */
    protected $guiasOperadorRel;

    /**
     * @ORM\Column(name="url_servicio", type="string", length=500, nullable=true)
     */
    private $urlServicio;

    /**
     * @return mixed
     */
    public function getCodigoOperadorPk()
    {
        return $this->codigoOperadorPk;
    }

    /**
     * @param mixed $codigoOperadorPk
     */
    public function setCodigoOperadorPk($codigoOperadorPk): void
    {
        $this->codigoOperadorPk = $codigoOperadorPk;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen): void
    {
        $this->imagen = $imagen;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getUsuariosOperadorRel()
    {
        return $this->usuariosOperadorRel;
    }

    /**
     * @param mixed $usuariosOperadorRel
     */
    public function setUsuariosOperadorRel($usuariosOperadorRel): void
    {
        $this->usuariosOperadorRel = $usuariosOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getGuiasOperadorRel()
    {
        return $this->guiasOperadorRel;
    }

    /**
     * @param mixed $guiasOperadorRel
     */
    public function setGuiasOperadorRel($guiasOperadorRel): void
    {
        $this->guiasOperadorRel = $guiasOperadorRel;
    }

    /**
     * @return mixed
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * @param mixed $numeroIdentificacion
     */
    public function setNumeroIdentificacion($numeroIdentificacion): void
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
    }

    /**
     * @return mixed
     */
    public function getUrlServicio()
    {
        return $this->urlServicio;
    }

    /**
     * @param mixed $urlServicio
     */
    public function setUrlServicio($urlServicio): void
    {
        $this->urlServicio = $urlServicio;
    }



}

