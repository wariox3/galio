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
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="operadorRel")
     */
    protected $usuariosOperadorRel;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="operadorRel")
     */
    protected $guiasOperadorRel;

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



}

