<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteGuiaTipoRepository")
 */
class TteGuiaTipo
{
    public $infoLog = [
        "primaryKey" => "codigoGuiaTipoPk",
        "todos"     => true,
    ];
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_guia_tipo_pk",type="string", length=20, nullable=false, unique=true)
     */
    private $codigoGuiaTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="guiaTipoRel")
     */
    protected $guiasGuiaTipoRel;

    /**
     * @return array
     */
    public function getInfoLog(): array
    {
        return $this->infoLog;
    }

    /**
     * @return mixed
     */
    public function getCodigoGuiaTipoPk()
    {
        return $this->codigoGuiaTipoPk;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function getGuiasGuiaTipoRel()
    {
        return $this->guiasGuiaTipoRel;
    }

    /**
     * @return mixed
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param mixed $orden
     */
    public function setOrden($orden): void
    {
        $this->orden = $orden;
    }


}

