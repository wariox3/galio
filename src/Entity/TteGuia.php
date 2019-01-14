<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteGuiaRepository")
 */
class TteGuia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoGuiaPk;

    /**
     * @ORM\Column(name="numero", type="float", nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(name="codigo_guia_tipo_fk", type="string", length=20, nullable=true)
     */
    private $codigoGuiaTipoFk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="codigo_ciudad_origen_fk", type="string", length=20, nullable=true)
     */
    private $codigoCiudadOrigenFk;

    /**
     * @ORM\Column(name="codigo_ciudad_destino_fk", type="string", length=20, nullable=true)
     */
    private $codigoCiudadDestinoFk;

    /**
     * @ORM\Column(name="remitente", type="string", length=80, nullable=true)
     */
    private $remitente;

    /**
     * @ORM\Column(name="nombre_destinatario", type="string", length=150, nullable=true)
     */
    private $nombreDestinatario;

    /**
     * @ORM\Column(name="direccion_destinatario", type="string", length=150, nullable=true)
     */
    private $direccionDestinatario;

    /**
     * @ORM\Column(name="telefono_destinatario", type="string", length=80, nullable=true)
     */
    private $telefonoDestinatario;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable=true)
     */
    private $fechaIngreso;

    /**
     * @ORM\Column(name="unidades", type="float", options={"default" : 0})
     */
    private $unidades = 0;

    /**
     * @ORM\Column(name="peso_real", type="float", options={"default" : 0})
     */
    private $pesoReal = 0;

    /**
     * @ORM\Column(name="peso_volumen", type="float", options={"default" : 0})
     */
    private $pesoVolumen = 0;

    /**
     * @ORM\Column(name="peso_facturado", type="float", options={"default" : 0})
     */
    private $pesoFacturado = 0;

    /**
     * @ORM\Column(name="vr_declara", type="float", options={"default" : 0})
     */
    private $vrDeclara = 0;

    /**
     * @ORM\Column(name="vr_flete", type="float", options={"default" : 0})
     */
    private $vrFlete = 0;

    /**
     * @ORM\Column(name="vr_manejo", type="float", options={"default" : 0})
     */
    private $vrManejo = 0;

    /**
     * @ORM\Column(name="vr_recaudo", type="float", options={"default" : 0})
     */
    private $vrRecaudo = 0;

    /**
     * @ORM\Column(name="vr_abono", type="float", options={"default" : 0})
     */
    private $vrAbono = 0;

    /**
     * @ORM\Column(name="vr_cobro_entrega", type="float", options={"default" : 0})
     */
    private $vrCobroEntrega = 0;

    /**
     * @ORM\Column(name="vr_costo_reexpedicion", type="float", options={"default" : 0})
     */
    private $vrCostoReexpedicion = 0;

    /**
     * @ORM\Column(name="codigo_producto_fk", type="integer", nullable=true)
     */
    private $codigoProductoFk;

    /**
     * @ORM\Column(name="usuario", type="string", length=25, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="comentario", type="string", length=2000, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="TteCiudad", inversedBy="guiasCiudadesOrigenesCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_origen_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadOrigenRel;

    /**
     * @ORM\ManyToOne(targetEntity="TteCiudad", inversedBy="guiasCiudadesDestinosCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_destino_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadDestinoRel;

    /**
     * @ORM\ManyToOne(targetEntity="TteProducto", inversedBy="guiasProductoRel")
     * @ORM\JoinColumn(name="codigo_producto_fk", referencedColumnName="codigo_producto_pk")
     */
    protected $productoRel;

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="guiasEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;

    /**
     * @return mixed
     */
    public function getCodigoGuiaPk()
    {
        return $this->codigoGuiaPk;
    }

    /**
     * @param mixed $codigoGuiaPk
     */
    public function setCodigoGuiaPk($codigoGuiaPk): void
    {
        $this->codigoGuiaPk = $codigoGuiaPk;
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
    public function getCodigoGuiaTipoFk()
    {
        return $this->codigoGuiaTipoFk;
    }

    /**
     * @param mixed $codigoGuiaTipoFk
     */
    public function setCodigoGuiaTipoFk($codigoGuiaTipoFk): void
    {
        $this->codigoGuiaTipoFk = $codigoGuiaTipoFk;
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
    public function getCodigoCiudadOrigenFk()
    {
        return $this->codigoCiudadOrigenFk;
    }

    /**
     * @param mixed $codigoCiudadOrigenFk
     */
    public function setCodigoCiudadOrigenFk($codigoCiudadOrigenFk): void
    {
        $this->codigoCiudadOrigenFk = $codigoCiudadOrigenFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadDestinoFk()
    {
        return $this->codigoCiudadDestinoFk;
    }

    /**
     * @param mixed $codigoCiudadDestinoFk
     */
    public function setCodigoCiudadDestinoFk($codigoCiudadDestinoFk): void
    {
        $this->codigoCiudadDestinoFk = $codigoCiudadDestinoFk;
    }

    /**
     * @return mixed
     */
    public function getRemitente()
    {
        return $this->remitente;
    }

    /**
     * @param mixed $remitente
     */
    public function setRemitente($remitente): void
    {
        $this->remitente = $remitente;
    }

    /**
     * @return mixed
     */
    public function getNombreDestinatario()
    {
        return $this->nombreDestinatario;
    }

    /**
     * @param mixed $nombreDestinatario
     */
    public function setNombreDestinatario($nombreDestinatario): void
    {
        $this->nombreDestinatario = $nombreDestinatario;
    }

    /**
     * @return mixed
     */
    public function getDireccionDestinatario()
    {
        return $this->direccionDestinatario;
    }

    /**
     * @param mixed $direccionDestinatario
     */
    public function setDireccionDestinatario($direccionDestinatario): void
    {
        $this->direccionDestinatario = $direccionDestinatario;
    }

    /**
     * @return mixed
     */
    public function getTelefonoDestinatario()
    {
        return $this->telefonoDestinatario;
    }

    /**
     * @param mixed $telefonoDestinatario
     */
    public function setTelefonoDestinatario($telefonoDestinatario): void
    {
        $this->telefonoDestinatario = $telefonoDestinatario;
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
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * @param mixed $fechaIngreso
     */
    public function setFechaIngreso($fechaIngreso): void
    {
        $this->fechaIngreso = $fechaIngreso;
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
    public function getPesoReal()
    {
        return $this->pesoReal;
    }

    /**
     * @param mixed $pesoReal
     */
    public function setPesoReal($pesoReal): void
    {
        $this->pesoReal = $pesoReal;
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
    public function getPesoFacturado()
    {
        return $this->pesoFacturado;
    }

    /**
     * @param mixed $pesoFacturado
     */
    public function setPesoFacturado($pesoFacturado): void
    {
        $this->pesoFacturado = $pesoFacturado;
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
    public function getVrFlete()
    {
        return $this->vrFlete;
    }

    /**
     * @param mixed $vrFlete
     */
    public function setVrFlete($vrFlete): void
    {
        $this->vrFlete = $vrFlete;
    }

    /**
     * @return mixed
     */
    public function getVrManejo()
    {
        return $this->vrManejo;
    }

    /**
     * @param mixed $vrManejo
     */
    public function setVrManejo($vrManejo): void
    {
        $this->vrManejo = $vrManejo;
    }

    /**
     * @return mixed
     */
    public function getVrRecaudo()
    {
        return $this->vrRecaudo;
    }

    /**
     * @param mixed $vrRecaudo
     */
    public function setVrRecaudo($vrRecaudo): void
    {
        $this->vrRecaudo = $vrRecaudo;
    }

    /**
     * @return mixed
     */
    public function getVrAbono()
    {
        return $this->vrAbono;
    }

    /**
     * @param mixed $vrAbono
     */
    public function setVrAbono($vrAbono): void
    {
        $this->vrAbono = $vrAbono;
    }

    /**
     * @return mixed
     */
    public function getVrCobroEntrega()
    {
        return $this->vrCobroEntrega;
    }

    /**
     * @param mixed $vrCobroEntrega
     */
    public function setVrCobroEntrega($vrCobroEntrega): void
    {
        $this->vrCobroEntrega = $vrCobroEntrega;
    }

    /**
     * @return mixed
     */
    public function getVrCostoReexpedicion()
    {
        return $this->vrCostoReexpedicion;
    }

    /**
     * @param mixed $vrCostoReexpedicion
     */
    public function setVrCostoReexpedicion($vrCostoReexpedicion): void
    {
        $this->vrCostoReexpedicion = $vrCostoReexpedicion;
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
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    /**
     * @return mixed
     */
    public function getCiudadOrigenRel()
    {
        return $this->ciudadOrigenRel;
    }

    /**
     * @param mixed $ciudadOrigenRel
     */
    public function setCiudadOrigenRel($ciudadOrigenRel): void
    {
        $this->ciudadOrigenRel = $ciudadOrigenRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadDestinoRel()
    {
        return $this->ciudadDestinoRel;
    }

    /**
     * @param mixed $ciudadDestinoRel
     */
    public function setCiudadDestinoRel($ciudadDestinoRel): void
    {
        $this->ciudadDestinoRel = $ciudadDestinoRel;
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
}
