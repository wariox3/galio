<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteProductoRepository")
 */
class TteProducto
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_producto_pk", type="string", length=20)
     */        
    private $codigoProductoPk;
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="string", length=20, nullable=true)
     */
    private $codigoOperadorFk;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="productoRel")
     */
    protected $guiasProductoRel;

    /**
     * @return mixed
     */
    public function getCodigoProductoPk()
    {
        return $this->codigoProductoPk;
    }

    /**
     * @param mixed $codigoProductoPk
     */
    public function setCodigoProductoPk($codigoProductoPk): void
    {
        $this->codigoProductoPk = $codigoProductoPk;
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
    public function getCodigoOperadorFk()
    {
        return $this->codigoOperadorFk;
    }

    /**
     * @param mixed $codigoOperadorFk
     */
    public function setCodigoOperadorFk($codigoOperadorFk): void
    {
        $this->codigoOperadorFk = $codigoOperadorFk;
    }

    /**
     * @return mixed
     */
    public function getGuiasProductoRel()
    {
        return $this->guiasProductoRel;
    }

    /**
     * @param mixed $guiasProductoRel
     */
    public function setGuiasProductoRel($guiasProductoRel): void
    {
        $this->guiasProductoRel = $guiasProductoRel;
    }
}