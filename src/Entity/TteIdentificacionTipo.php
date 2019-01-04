<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteIdentificacionTipoRepository")
 */
class TteIdentificacionTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_identificacion_tipo_pk", type="string", length=2)
     */        
    private $codigoIdentificacionTipoPk;
    
    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */    
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="TteDestinatario", mappedBy="identificacionTipoRel")
     */
    protected $destinatariosIdentificacionTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoIdentificacionTipoPk()
    {
        return $this->codigoIdentificacionTipoPk;
    }

    /**
     * @param mixed $codigoIdentificacionTipoPk
     */
    public function setCodigoIdentificacionTipoPk($codigoIdentificacionTipoPk): void
    {
        $this->codigoIdentificacionTipoPk = $codigoIdentificacionTipoPk;
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
    public function getDestinatariosIdentificacionTipoRel()
    {
        return $this->destinatariosIdentificacionTipoRel;
    }

    /**
     * @param mixed $destinatariosIdentificacionTipoRel
     */
    public function setDestinatariosIdentificacionTipoRel($destinatariosIdentificacionTipoRel): void
    {
        $this->destinatariosIdentificacionTipoRel = $destinatariosIdentificacionTipoRel;
    }
}
