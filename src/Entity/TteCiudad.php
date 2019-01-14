<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteCiudadRepository")
 */
class TteCiudad
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_ciudad_pk", type="string", length=20, nullable=false, unique=true)
     */
    private $codigoCiudadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_departamento_fk", type="string", length=2, nullable=true)
     */
    private $codigoDepartamentoFk;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="string", length=20, nullable=true)
     */
    private $codigoOperadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="TteDepartamento", inversedBy="ciudadesDepartamentoRel")
     * @ORM\JoinColumn(name="codigo_departamento_fk", referencedColumnName="codigo_departamento_pk")
     */
    protected $departamentoRel;

    /**
     * @ORM\OneToMany(targetEntity="TteDestinatario", mappedBy="ciudadRel")
     */
    protected $destinatariosCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="ciudadOrigenRel")
     */
    protected $guiasCiudadesOrigenesCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="ciudadDestinoRel")
     */
    protected $guiasCiudadesDestinosCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="TtePrecio", mappedBy="ciudadOrigenRel")
     */
    protected $preciosCiudadesOrigenesCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="TtePrecio", mappedBy="ciudadDestinoRel")
     */
    protected $preciosCiudadesDestinosCiudadRel;

    /**
     * @return mixed
     */
    public function getCodigoCiudadPk()
    {
        return $this->codigoCiudadPk;
    }

    /**
     * @param mixed $codigoCiudadPk
     */
    public function setCodigoCiudadPk($codigoCiudadPk): void
    {
        $this->codigoCiudadPk = $codigoCiudadPk;
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
    public function getCodigoDepartamentoFk()
    {
        return $this->codigoDepartamentoFk;
    }

    /**
     * @param mixed $codigoDepartamentoFk
     */
    public function setCodigoDepartamentoFk($codigoDepartamentoFk): void
    {
        $this->codigoDepartamentoFk = $codigoDepartamentoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoOperadorFk()
    {
        return $this->codigoOperadorFk;
    }

    /**
     * @param mixed $codigoOperadorFk
     */
    public function setCodigoOperadorFk($codigoOperadorFk): void
    {
        $this->codigoOperadorFk = $codigoOperadorFk;
    }

    /**
     * @return mixed
     */
    public function getDepartamentoRel()
    {
        return $this->departamentoRel;
    }

    /**
     * @param mixed $departamentoRel
     */
    public function setDepartamentoRel($departamentoRel): void
    {
        $this->departamentoRel = $departamentoRel;
    }

    /**
     * @return mixed
     */
    public function getDestinatariosCiudadRel()
    {
        return $this->destinatariosCiudadRel;
    }

    /**
     * @param mixed $destinatariosCiudadRel
     */
    public function setDestinatariosCiudadRel($destinatariosCiudadRel): void
    {
        $this->destinatariosCiudadRel = $destinatariosCiudadRel;
    }

    /**
     * @return mixed
     */
    public function getGuiasCiudadesOrigenesCiudadRel()
    {
        return $this->guiasCiudadesOrigenesCiudadRel;
    }

    /**
     * @param mixed $guiasCiudadesOrigenesCiudadRel
     */
    public function setGuiasCiudadesOrigenesCiudadRel($guiasCiudadesOrigenesCiudadRel): void
    {
        $this->guiasCiudadesOrigenesCiudadRel = $guiasCiudadesOrigenesCiudadRel;
    }

    /**
     * @return mixed
     */
    public function getGuiasCiudadesDestinosCiudadRel()
    {
        return $this->guiasCiudadesDestinosCiudadRel;
    }

    /**
     * @param mixed $guiasCiudadesDestinosCiudadRel
     */
    public function setGuiasCiudadesDestinosCiudadRel($guiasCiudadesDestinosCiudadRel): void
    {
        $this->guiasCiudadesDestinosCiudadRel = $guiasCiudadesDestinosCiudadRel;
    }

    /**
     * @return mixed
     */
    public function getPreciosCiudadesOrigenesCiudadRel()
    {
        return $this->preciosCiudadesOrigenesCiudadRel;
    }

    /**
     * @param mixed $preciosCiudadesOrigenesCiudadRel
     */
    public function setPreciosCiudadesOrigenesCiudadRel($preciosCiudadesOrigenesCiudadRel): void
    {
        $this->preciosCiudadesOrigenesCiudadRel = $preciosCiudadesOrigenesCiudadRel;
    }

    /**
     * @return mixed
     */
    public function getPreciosCiudadesDestinosCiudadRel()
    {
        return $this->preciosCiudadesDestinosCiudadRel;
    }

    /**
     * @param mixed $preciosCiudadesDestinosCiudadRel
     */
    public function setPreciosCiudadesDestinosCiudadRel($preciosCiudadesDestinosCiudadRel): void
    {
        $this->preciosCiudadesDestinosCiudadRel = $preciosCiudadesDestinosCiudadRel;
    }
}

