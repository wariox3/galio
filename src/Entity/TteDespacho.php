<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteDespachoRepository")
 */
class TteDespacho
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_despacho_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoDespachoPk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="numero", type="float", nullable=true)
     */
    private $numero = 0;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="guias", type="integer", nullable=true)
     */
    private $guias = 0;

    /**
     * @ORM\Column(name="unidades", type="integer", nullable=true)
     */
    private $unidades = 0;

    /**
     * @ORM\Column(name="peso", type="float", nullable=true)
     */
    private $peso = 0;

    /**
     * @ORM\Column(name="peso_volumen", type="float", nullable=true)
     */
    private $pesoVolumen = 0;

    /**
     * @ORM\Column(name="vr_declara", type="float", nullable=true)
     */
    private $vrDeclara = 0;

    /**
     * @ORM\Column(name="estado_impreso", type="boolean", nullable=true))
     */
    private $estadoImpreso = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean", nullable=true))
     */
    private $estadoAprobado = false;

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="despachosEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="despachoRel")
     */
    protected $guiasDespachoRel;

    /**
     * @return mixed
     */
    public function getCodigoDespachoPk()
    {
        return $this->codigoDespachoPk;
    }

    /**
     * @param mixed $codigoDespachoPk
     */
    public function setCodigoDespachoPk($codigoDespachoPk): void
    {
        $this->codigoDespachoPk = $codigoDespachoPk;
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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getGuias()
    {
        return $this->guias;
    }

    /**
     * @param mixed $guias
     */
    public function setGuias($guias): void
    {
        $this->guias = $guias;
    }

    /**
     * @return mixed
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * @param mixed $unidades
     */
    public function setUnidades($unidades): void
    {
        $this->unidades = $unidades;
    }

    /**
     * @return mixed
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * @param mixed $peso
     */
    public function setPeso($peso): void
    {
        $this->peso = $peso;
    }

    /**
     * @return mixed
     */
    public function getPesoVolumen()
    {
        return $this->pesoVolumen;
    }

    /**
     * @param mixed $pesoVolumen
     */
    public function setPesoVolumen($pesoVolumen): void
    {
        $this->pesoVolumen = $pesoVolumen;
    }

    /**
     * @return mixed
     */
    public function getVrDeclara()
    {
        return $this->vrDeclara;
    }

    /**
     * @param mixed $vrDeclara
     */
    public function setVrDeclara($vrDeclara): void
    {
        $this->vrDeclara = $vrDeclara;
    }

    /**
     * @return mixed
     */
    public function getEstadoImpreso()
    {
        return $this->estadoImpreso;
    }

    /**
     * @param mixed $estadoImpreso
     */
    public function setEstadoImpreso($estadoImpreso): void
    {
        $this->estadoImpreso = $estadoImpreso;
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
    public function getGuiasDespachoRel()
    {
        return $this->guiasDespachoRel;
    }

    /**
     * @param mixed $guiasDespachoRel
     */
    public function setGuiasDespachoRel($guiasDespachoRel): void
    {
        $this->guiasDespachoRel = $guiasDespachoRel;
    }

    /**
     * @return mixed
     */
    public function getEstadoAprobado()
    {
        return $this->estadoAprobado;
    }

    /**
     * @param mixed $estadoAprobado
     */
    public function setEstadoAprobado($estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
    }


}

