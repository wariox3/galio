<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteEmpresaRepository")
 */
class TteEmpresa
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_empresa_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoEmpresaPk;           
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */    
    private $nombre;

    /**
     * @ORM\Column(name="nit", type="string", length=15, nullable=true)
     */    
    private $nit;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="string",length=20, nullable=true)
     */
    private $codigoOperadorFk;

    /**
     * @ORM\Column(name="codigo_condicion_fk", type="integer", nullable=true)
     */
    private $codigoCondicionFk;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="tipo_liquidacion", type="string", length=1, nullable=true, options={"default" : "K"})
     */
    private $tipoLiquidacion;

    /**
     * @ORM\Column(name="lista_precio", type="integer", nullable=true)
     */
    private $listaPrecio;
    
    /**
     * @ORM\Column(name="direccion", type="string", length=120, nullable=true)
     */    
    private $direccion;    
    
    /**
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */    
    private $telefono;    

    /**
     * @ORM\Column(name="consecutivo_guia", type="integer")
     */
    private $consecutivoGuia = 0;

    /**
     * @ORM\Column(name="consecutivo_guia_desde", type="integer")
     */
    private $consecutivoGuiaDesde = 0;

    /**
     * @ORM\Column(name="consecutivo_guia_hasta", type="integer")
     */
    private $consecutivoGuiaHasta = 0;
    
    /**
     * @ORM\Column(name="porcentaje_manejo", type="float")
     */
    private $porcentajeManejo = 0;    
    
    /**
     * @ORM\Column(name="manejo_minimo_despacho", type="float")
     */
    private $manejoMinimoDespacho = 0;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="empresaRel")
     */
    protected $usuariosEmpresaRel;

    /**
     * @ORM\OneToMany(targetEntity="TteDestinatario", mappedBy="empresaRel")
     */
    protected $destinatariosEmpresaRel;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="empresaRel")
     */
    protected $guiasEmpresaRel;

    /**
     * @ORM\OneToMany(targetEntity="TteDespacho", mappedBy="empresaRel")
     */
    protected $despachosEmpresaRel;

    /**
     * @ORM\OneToMany(targetEntity="TteProducto", mappedBy="empresaRel")
     */
    protected $productosEmpresaRel;

    /**
     * @return mixed
     */
    public function getCodigoEmpresaPk()
    {
        return $this->codigoEmpresaPk;
    }

    /**
     * @param mixed $codigoEmpresaPk
     */
    public function setCodigoEmpresaPk($codigoEmpresaPk): void
    {
        $this->codigoEmpresaPk = $codigoEmpresaPk;
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
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed $nit
     */
    public function setNit($nit): void
    {
        $this->nit = $nit;
    }

    /**
     * @return mixed
     */
    public function getListaPrecio()
    {
        return $this->listaPrecio;
    }

    /**
     * @param mixed $listaPrecio
     */
    public function setListaPrecio($listaPrecio): void
    {
        $this->listaPrecio = $listaPrecio;
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
    public function getConsecutivoGuia()
    {
        return $this->consecutivoGuia;
    }

    /**
     * @param mixed $consecutivoGuia
     */
    public function setConsecutivoGuia($consecutivoGuia): void
    {
        $this->consecutivoGuia = $consecutivoGuia;
    }

    /**
     * @return mixed
     */
    public function getConsecutivoGuiaHasta()
    {
        return $this->consecutivoGuiaHasta;
    }

    /**
     * @param mixed $consecutivoGuiaHasta
     */
    public function setConsecutivoGuiaHasta($consecutivoGuiaHasta): void
    {
        $this->consecutivoGuiaHasta = $consecutivoGuiaHasta;
    }

    /**
     * @return mixed
     */
    public function getPorcentajeManejo()
    {
        return $this->porcentajeManejo;
    }

    /**
     * @param mixed $porcentajeManejo
     */
    public function setPorcentajeManejo($porcentajeManejo): void
    {
        $this->porcentajeManejo = $porcentajeManejo;
    }

    /**
     * @return mixed
     */
    public function getManejoMinimoDespacho()
    {
        return $this->manejoMinimoDespacho;
    }

    /**
     * @param mixed $manejoMinimoDespacho
     */
    public function setManejoMinimoDespacho($manejoMinimoDespacho): void
    {
        $this->manejoMinimoDespacho = $manejoMinimoDespacho;
    }

    /**
     * @return mixed
     */
    public function getUsuariosEmpresaRel()
    {
        return $this->usuariosEmpresaRel;
    }

    /**
     * @param mixed $usuariosEmpresaRel
     */
    public function setUsuariosEmpresaRel($usuariosEmpresaRel): void
    {
        $this->usuariosEmpresaRel = $usuariosEmpresaRel;
    }

    /**
     * @return mixed
     */
    public function getDestinatariosEmpresaRel()
    {
        return $this->destinatariosEmpresaRel;
    }

    /**
     * @param mixed $destinatariosEmpresaRel
     */
    public function setDestinatariosEmpresaRel($destinatariosEmpresaRel): void
    {
        $this->destinatariosEmpresaRel = $destinatariosEmpresaRel;
    }

    /**
     * @return mixed
     */
    public function getGuiasEmpresaRel()
    {
        return $this->guiasEmpresaRel;
    }

    /**
     * @param mixed $guiasEmpresaRel
     */
    public function setGuiasEmpresaRel($guiasEmpresaRel): void
    {
        $this->guiasEmpresaRel = $guiasEmpresaRel;
    }

    /**
     * @return mixed
     */
    public function getDespachosEmpresaRel()
    {
        return $this->despachosEmpresaRel;
    }

    /**
     * @param mixed $despachosEmpresaRel
     */
    public function setDespachosEmpresaRel($despachosEmpresaRel): void
    {
        $this->despachosEmpresaRel = $despachosEmpresaRel;
    }

    /**
     * @return mixed
     */
    public function getConsecutivoGuiaDesde()
    {
        return $this->consecutivoGuiaDesde;
    }

    /**
     * @param mixed $consecutivoGuiaDesde
     */
    public function setConsecutivoGuiaDesde( $consecutivoGuiaDesde ): void
    {
        $this->consecutivoGuiaDesde = $consecutivoGuiaDesde;
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
    public function getCodigoCondicionFk()
    {
        return $this->codigoCondicionFk;
    }

    /**
     * @param mixed $codigoCondicionFk
     */
    public function setCodigoCondicionFk($codigoCondicionFk): void
    {
        $this->codigoCondicionFk = $codigoCondicionFk;
    }

    /**
     * @return mixed
     */
    public function getTipoLiquidacion()
    {
        return $this->tipoLiquidacion;
    }

    /**
     * @param mixed $tipoLiquidacion
     */
    public function setTipoLiquidacion($tipoLiquidacion): void
    {
        $this->tipoLiquidacion = $tipoLiquidacion;
    }

    /**
     * @return mixed
     */
    public function getCodigoClienteFk()
    {
        return $this->codigoClienteFk;
    }

    /**
     * @param mixed $codigoClienteFk
     */
    public function setCodigoClienteFk($codigoClienteFk): void
    {
        $this->codigoClienteFk = $codigoClienteFk;
    }




}
