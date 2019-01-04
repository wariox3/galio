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
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="codigo_ciudad_origen_fk", type="string", length=20, nullable=true)
     */
    private $codigoCiudadOrigenFk;

    /**
     * @ORM\Column(name="codigo_ciudad_destino_fk", type="string", length=20, nullable=true)
     */
    private $codigoCiudadDestinoFk;

    /**
     * @ORM\Column(name="documento_cliente", type="string", length=80, nullable=true)
     */
    private $documentoCliente;

    /**
     * @ORM\Column(name="relacion_cliente", type="string", length=50, nullable=true)
     */
    private $relacionCliente;

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
     * @ORM\Column(name="codigo_despacho_fk", type="integer", nullable=true)
     */
    private $codigoDespachoFk;

    /**
     * @ORM\Column(name="codigo_cumplido_fk", type="integer", nullable=true)
     */
    private $codigoCumplidoFk;

    /**
     * @ORM\Column(name="codigo_recaudo_devolucion_fk", type="integer", nullable=true)
     */
    private $codigoRecaudoDevolucionFk;

    /**
     * @ORM\Column(name="codigo_recaudo_cobro_fk", type="integer", nullable=true)
     */
    private $codigoRecaudoCobroFk;

    /**
     * @ORM\Column(name="codigo_factura_fk", type="integer", nullable=true)
     */
    private $codigoFacturaFk;

    /**
     * @ORM\Column(name="codigo_factura_planilla_fk", type="integer", nullable=true)
     */
    private $codigoFacturaPlanillaFk;

    /**
     * @ORM\Column(name="codigo_ruta_fk", type="string", length=20, nullable=true)
     */
    private $codigoRutaFk;

    /**
     * @ORM\Column(name="orden_ruta", type="integer", nullable=true, options={"default" : 0})
     */
    private $ordenRuta = 0;

    /**
     * @ORM\Column(name="factura", type="boolean",options={"default":false})
     */
    private $factura = false;

    /**
     * @ORM\Column(name="codigo_servicio_fk", type="string", length=20, nullable=true)
     */
    private $codigoServicioFk;

    /**
     * @ORM\Column(name="codigo_producto_fk", type="string", length=20, nullable=true)
     */
    private $codigoProductoFk;

    /**
     * @ORM\Column(name="codigo_empaque_fk", type="string", length=20, nullable=true)
     */
    private $codigoEmpaqueFk;

    /**
     * @ORM\Column(name="codigo_condicion_fk", type="integer", nullable=true)
     */
    private $codigoCondicionFk;

    /**
     * @ORM\Column(name="reexpedicion", type="boolean",options={"default":false})
     */
    private $reexpedicion = false;

    /**
     * @ORM\Column(name="cortesia", type="boolean",options={"default":false})
     */
    private $cortesia = false;

    /**
     * @ORM\Column(name="mercancia_peligrosa", type="boolean",options={"default" : false}, nullable=true)
     */
    private $mercanciaPeligrosa = false;

    /**
     * @ORM\Column(name="usuario", type="string", length=25, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="empaque_referencia", type="string", length=80, nullable=true)
     */
    private $empaqueReferencia;

    /**
     * @ORM\Column(name="tipo_liquidacion", type="string", length=1, nullable=true, options={"default" : "K"})
     */
    private $tipoLiquidacion;

    /**
     * @ORM\Column(name="comentario", type="string", length=2000, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="TteCiudad", inversedBy="ciudadesOrigenesCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_origen_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadOrigenRel;

    /**
     * @ORM\ManyToOne(targetEntity="TteCiudad", inversedBy="ciudadesDestinosCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_destino_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadDestinoRel;
}
