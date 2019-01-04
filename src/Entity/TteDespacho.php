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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="codigo_despacho_pk")
     */
    private $codigoDespachoPk;

    /**
     * @ORM\Column(name="numero", type="float", nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(name="numero_rndc", type="string", length=40, nullable=true)
     */
    private $numeroRndc;

    /**
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @ORM\Column(name="fecha_salida", type="datetime", nullable=true)
     */
    private $fechaSalida;

    /**
     * @ORM\Column(name="fecha_llegada", type="datetime", nullable=true)
     */
    private $fechaLlegada;

    /**
     * @ORM\Column(name="fecha_soporte", type="datetime", nullable=true)
     */
    private $fechaSoporte;

    /**
     * @ORM\Column(name="codigo_operacion_fk", type="string", length=20, nullable=true)
     */
    private $codigoOperacionFk;

    /**
     * @ORM\Column(name="codigo_ciudad_origen_fk", type="string", length=20, nullable=true)
     */
    private $codigoCiudadOrigenFk;

    /**
     * @ORM\Column(name="codigo_ciudad_destino_fk", type="string", length=20, nullable=true)
     */
    private $codigoCiudadDestinoFk;

    /**
     * @ORM\Column(name="codigo_vehiculo_fk", type="string", length=20, nullable=true)
     */
    private $codigoVehiculoFk;

    /**
     * @ORM\Column(name="codigo_conductor_fk", type="integer", nullable=true)
     */
    private $codigoConductorFk;

    /**
     * @ORM\Column(name="codigo_ruta_fk", type="string", length=20, nullable=true)
     */
    private $codigoRutaFk;

    /**
     * @ORM\Column(name="cantidad", type="float", options={"default" : 0})
     */
    private $cantidad = 0;

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
     * @ORM\Column(name="peso_costo", type="float", options={"default" : 0})
     */
    private $pesoCosto = 0;

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
     * @ORM\Column(name="vr_flete_pago", type="float", options={"default" : 0})
     */
    private $vrFletePago = 0;

    /**
     * @ORM\Column(name="vr_anticipo", type="float", options={"default" : 0})
     */
    private $vrAnticipo = 0;

    /**
     * @ORM\Column(name="vr_industria_comercio", type="float", options={"default" : 0})
     */
    private $vrIndustriaComercio = 0;

    /**
     * @ORM\Column(name="vr_retencion_fuente", type="float", options={"default" : 0})
     */
    private $vrRetencionFuente = 0;

    /**
     * @ORM\Column(name="vr_total", type="float", options={"default" : 0})
     */
    private $vrTotal = 0;

    /**
     * @ORM\Column(name="vr_total_neto", type="float", options={"default" : 0})
     */
    private $vrTotalNeto = 0;

    /**
     * @ORM\Column(name="vr_descuento_papeleria", type="float", options={"default" : 0})
     */
    private $vrDescuentoPapeleria = 0;

    /**
     * @ORM\Column(name="vr_descuento_seguridad", type="float", options={"default" : 0})
     */
    private $vrDescuentoSeguridad = 0;

    /**
     * @ORM\Column(name="vr_descuento_cargue", type="float", options={"default" : 0})
     */
    private $vrDescuentoCargue = 0;

    /**
     * @ORM\Column(name="vr_descuento_estampilla", type="float", options={"default" : 0})
     */
    private $vrDescuentoEstampilla = 0;

    /**
     * @ORM\Column(name="vr_cobro_entrega", type="float", options={"default" : 0})
     */
    private $vrCobroEntrega = 0;

    /**
     * @ORM\Column(name="vr_cobro_entrega_rechazado", type="float", options={"default" : 0})
     */
    private $vrCobroEntregaRechazado = 0;

    /**
     * @ORM\Column(name="vr_saldo", type="float", options={"default" : 0})
     */
    private $vrSaldo = 0;

    /**
     * @ORM\Column(name="vr_costo", type="float", nullable=true, options={"default" : 0})
     */
    private $vrCosto = 0;

    /**
     * @ORM\Column(name="vr_costo_base", type="float", nullable=true, options={"default" : 0})
     */
    private $vrCostoBase = 0;

    /**
     * @ORM\Column(name="porcentaje_rentabilidad", type="float", nullable=true, options={"default" : 0})
     */
    private $porcentajeRentabilidad = 0;

    /**
     * @ORM\Column(name="estado_autorizado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoAutorizado = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="estado_cerrado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoCerrado = false;

    /**
     * @ORM\Column(name="estado_soporte", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoSoporte = false;

    /**
     * @ORM\Column(name="estado_anulado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoAnulado = false;

    /**
     * @ORM\Column(name="estado_contabilizado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoContabilizado = false;

    /**
     * @ORM\Column(name="estado_cumplir_rndc", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoCumplirRndc = false;

    /**
     * @ORM\Column(name="estado_novedad", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoNovedad = false;

    /**
     * @ORM\Column(name="estado_novedad_solucion", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoNovedadSolucion = false;

    /**
     * @ORM\Column(name="comentario", type="string", length=2000, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_despacho_tipo_fk", type="string", length=20, nullable=true)
     */
    private $codigoDespachoTipoFk;

    /**
     * @ORM\Column(name="usuario", type="string", length=25, nullable=true)
     */
    private $usuario;
}

