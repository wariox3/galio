<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteProductoEmpresaRepository")
 */
class TteProductoEmpresa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoProductoEmpresaPk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="codigo_producto_fk", type="string", length=20, nullable=true)
     */
    private $codigoProductoFk;

    /**
     * @ORM\Column(type="integer", name="orden", nullable=true)
     */
    private $orden;

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="productosEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;

    /**
     * @ORM\ManyToOne(targetEntity="TteProducto", inversedBy="productosEmpresaProductoRel")
     * @ORM\JoinColumn(name="codigo_producto_fk", referencedColumnName="codigo_producto_pk")
     */
    protected $productoRel;

    /**
     * @return mixed
     */
    public function getCodigoProductoEmpresaPk()
    {
        return $this->codigoProductoEmpresaPk;
    }

    /**
     * @param mixed $codigoProductoEmpresaPk
     */
    public function setCodigoProductoEmpresaPk($codigoProductoEmpresaPk): void
    {
        $this->codigoProductoEmpresaPk = $codigoProductoEmpresaPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEmpresaFk()
    {
        return $this->codigoEmpresaFk;
    }

    /**
     * @param mixed $codigoEmpresaFk
     */
    public function setCodigoEmpresaFk($codigoEmpresaFk): void
    {
        $this->codigoEmpresaFk = $codigoEmpresaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoProductoFk()
    {
        return $this->codigoProductoFk;
    }

    /**
     * @param mixed $codigoProductoFk
     */
    public function setCodigoProductoFk($codigoProductoFk): void
    {
        $this->codigoProductoFk = $codigoProductoFk;
    }

    /**
     * @return mixed
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param mixed $orden
     */
    public function setOrden($orden): void
    {
        $this->orden = $orden;
    }

    /**
     * @return mixed
     */
    public function getEmpresaRel()
    {
        return $this->empresaRel;
    }

    /**
     * @param mixed $empresaRel
     */
    public function setEmpresaRel($empresaRel): void
    {
        $this->empresaRel = $empresaRel;
    }

    /**
     * @return mixed
     */
    public function getProductoRel()
    {
        return $this->productoRel;
    }

    /**
     * @param mixed $productoRel
     */
    public function setProductoRel($productoRel): void
    {
        $this->productoRel = $productoRel;
    }


}
