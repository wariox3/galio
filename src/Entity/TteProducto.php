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
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_producto_pk", type="integer")
     */        
    private $codigoProductoPk;
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="TtePrecio", mappedBy="productoRel")
     */
    protected $preciosProductoRel;

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
    public function getPreciosProductoRel()
    {
        return $this->preciosProductoRel;
    }

    /**
     * @param mixed $preciosProductoRel
     */
    public function setPreciosProductoRel($preciosProductoRel): void
    {
        $this->preciosProductoRel = $preciosProductoRel;
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
