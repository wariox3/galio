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
}
