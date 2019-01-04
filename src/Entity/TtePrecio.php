<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TtePrecioRepository")
 */
class TtePrecio
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_precio_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoPrecioPk;

    /**
     * @ORM\Column(name="codigo_ciudad_origen_fk", type="integer", nullable=true)
     */    
    private $codigoCiudadOrigenFk;    
    
    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */    
    private $codigoCiudadFk;    
    
    /**
     * @ORM\Column(name="codigo_producto_fk", type="integer", nullable=true)
     */    
    private $codigoProductoFk;
    
    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */    
    private $codigoEmpresaFk;    
    
    /**
     * @ORM\Column(name="vr_kilo", type="float")
     */
    private $vrKilo = 0;    
    
    /**
     * @ORM\Column(name="vr_unidad", type="float")
     */
    private $vrUnidad = 0;    

}
