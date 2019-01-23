<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TteDestinatarioRepository")
 */
class TteDestinatario
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_destinatario_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoDestinatarioPk;           
    
    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */    
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="codigo_identificacion_tipo_fk", type="string", length=2, nullable=true)
     */
    private $codigoIdentificacionTipoFk;
    
    /**
     * @ORM\Column(name="nombre_corto", type="string", length=80, nullable=true)
     */    
    private $nombreCorto;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", length=30, nullable=true)
     */    
    private $numeroIdentificacion;
    
    /**
     * @ORM\Column(name="digito_verificacion", type="string", length=1, nullable=true)
     */    
    private $digitoVerificacion;      
    
    /**
     * @ORM\Column(name="nombre1", type="string", length=60, nullable=true)
     */    
    private $nombre1;

    /**
     * @ORM\Column(name="nombre2", type="string", length=60, nullable=true)
     */    
    private $nombre2;
    
    /**
     * @ORM\Column(name="apellido1", type="string", length=60, nullable=true)
     */    
    private $apellido1;    
    
    /**
     * @ORM\Column(name="apellido2", type="string", length=60, nullable=true)
     */    
    private $apellido2;    
    
    /**
     * @ORM\Column(name="direccion", type="string", length=100, nullable=true)
     */    
    private $direccion;    

    /**
     * @ORM\Column(name="barrio", type="string", length=80, nullable=true)
     */    
    private $barrio; 
    
    /**
     * @ORM\Column(name="telefono", type="string", length=40, nullable=true)
     */    
    private $telefono;    

    /**
     * @ORM\Column(name="correo", type="string", length=80, nullable=true)
     */    
    private $correo;

    /**
     * @ORM\ManyToOne(targetEntity="TteIdentificacionTipo", inversedBy="destinatariosIdentificacionTipoRel")
     * @ORM\JoinColumn(name="codigo_identificacion_tipo_fk", referencedColumnName="codigo_identificacion_tipo_pk")
     */
    protected $identificacionTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="TteCiudad", inversedBy="destinatariosCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadRel;

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="destinatariosEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;

    /**
     * @ORM\OneToMany(targetEntity="TteGuia", mappedBy="destinatarioRel")
     */
    protected $guiasDestinatarioRel;

    /**
     * @return mixed
     */
    public function getCodigoDestinatarioPk()
    {
        return $this->codigoDestinatarioPk;
    }

    /**
     * @param mixed $codigoDestinatarioPk
     */
    public function setCodigoDestinatarioPk($codigoDestinatarioPk): void
    {
        $this->codigoDestinatarioPk = $codigoDestinatarioPk;
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
    public function getCodigoCiudadFk()
    {
        return $this->codigoCiudadFk;
    }

    /**
     * @param mixed $codigoCiudadFk
     */
    public function setCodigoCiudadFk($codigoCiudadFk): void
    {
        $this->codigoCiudadFk = $codigoCiudadFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoIdentificacionTipoFk()
    {
        return $this->codigoIdentificacionTipoFk;
    }

    /**
     * @param mixed $codigoIdentificacionTipoFk
     */
    public function setCodigoIdentificacionTipoFk($codigoIdentificacionTipoFk): void
    {
        $this->codigoIdentificacionTipoFk = $codigoIdentificacionTipoFk;
    }

    /**
     * @return mixed
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }

    /**
     * @param mixed $nombreCorto
     */
    public function setNombreCorto($nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
    }

    /**
     * @return mixed
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * @param mixed $numeroIdentificacion
     */
    public function setNumeroIdentificacion($numeroIdentificacion): void
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
    }

    /**
     * @return mixed
     */
    public function getDigitoVerificacion()
    {
        return $this->digitoVerificacion;
    }

    /**
     * @param mixed $digitoVerificacion
     */
    public function setDigitoVerificacion($digitoVerificacion): void
    {
        $this->digitoVerificacion = $digitoVerificacion;
    }

    /**
     * @return mixed
     */
    public function getNombre1()
    {
        return $this->nombre1;
    }

    /**
     * @param mixed $nombre1
     */
    public function setNombre1($nombre1): void
    {
        $this->nombre1 = $nombre1;
    }

    /**
     * @return mixed
     */
    public function getNombre2()
    {
        return $this->nombre2;
    }

    /**
     * @param mixed $nombre2
     */
    public function setNombre2($nombre2): void
    {
        $this->nombre2 = $nombre2;
    }

    /**
     * @return mixed
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * @param mixed $apellido1
     */
    public function setApellido1($apellido1): void
    {
        $this->apellido1 = $apellido1;
    }

    /**
     * @return mixed
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * @param mixed $apellido2
     */
    public function setApellido2($apellido2): void
    {
        $this->apellido2 = $apellido2;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getBarrio()
    {
        return $this->barrio;
    }

    /**
     * @param mixed $barrio
     */
    public function setBarrio($barrio): void
    {
        $this->barrio = $barrio;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getIdentificacionTipoRel()
    {
        return $this->identificacionTipoRel;
    }

    /**
     * @param mixed $identificacionTipoRel
     */
    public function setIdentificacionTipoRel($identificacionTipoRel): void
    {
        $this->identificacionTipoRel = $identificacionTipoRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadRel()
    {
        return $this->ciudadRel;
    }

    /**
     * @param mixed $ciudadRel
     */
    public function setCiudadRel($ciudadRel): void
    {
        $this->ciudadRel = $ciudadRel;
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

    /**
     * @return mixed
     */
    public function getGuiasDestinatarioRel()
    {
        return $this->guiasDestinatarioRel;
    }

    /**
     * @param mixed $guiasDestinatarioRel
     */
    public function setGuiasDestinatarioRel($guiasDestinatarioRel): void
    {
        $this->guiasDestinatarioRel = $guiasDestinatarioRel;
    }
}
