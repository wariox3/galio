<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenIdentificacionRepository")
 */
class GenIdentificacion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_identificacion_pk", type="string", length=2)
     */        
    private $codigoIdentificacionPk;
    
    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */    
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="TteDestinatario", mappedBy="identificacionRel")
     */
    protected $destinatariosIdentificacionRel;

    /**
     * @return mixed
     */
    public function getCodigoIdentificacionPk()
    {
        return $this->codigoIdentificacionPk;
    }

    /**
     * @param mixed $codigoIdentificacionPk
     */
    public function setCodigoIdentificacionPk($codigoIdentificacionPk): void
    {
        $this->codigoIdentificacionPk = $codigoIdentificacionPk;
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
    public function getDestinatariosIdentificacionRel()
    {
        return $this->destinatariosIdentificacionRel;
    }

    /**
     * @param mixed $destinatariosIdentificacionRel
     */
    public function setDestinatariosIdentificacionRel($destinatariosIdentificacionRel): void
    {
        $this->destinatariosIdentificacionRel = $destinatariosIdentificacionRel;
    }


}
