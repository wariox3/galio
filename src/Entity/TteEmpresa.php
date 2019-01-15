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
}
