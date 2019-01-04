<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteDepartamentoRepository")
 */
class TteDepartamento
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_departamento_pk", type="string", length=2)
     */
    private $codigoDepartamentoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="TteCiudad", mappedBy="departamentoRel")
     */
    protected $ciudadesDepartamentoRel;

    /**
     * @return mixed
     */
    public function getCodigoDepartamentoPk()
    {
        return $this->codigoDepartamentoPk;
    }

    /**
     * @param mixed $codigoDepartamentoPk
     */
    public function setCodigoDepartamentoPk($codigoDepartamentoPk): void
    {
        $this->codigoDepartamentoPk = $codigoDepartamentoPk;
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
    public function getCiudadesDepartamentoRel()
    {
        return $this->ciudadesDepartamentoRel;
    }

    /**
     * @param mixed $ciudadesDepartamentoRel
     */
    public function setCiudadesDepartamentoRel($ciudadesDepartamentoRel): void
    {
        $this->ciudadesDepartamentoRel = $ciudadesDepartamentoRel;
    }
}

