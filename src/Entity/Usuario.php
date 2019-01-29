<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="string", name="username", length=25)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(name="admin", type="boolean", options={"default":false} ,nullable=true)
     */
    private $admin = false;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="codigo_operador_fk", type="string",length=20, nullable=true)
     */
    private $codigoOperadorFk;

    /**
     * @ORM\Column(name="operacion", type="string",length=20, nullable=true)
     */
    private $operacion;

    /**
     * @ORM\ManyToOne(targetEntity="TteEmpresa", inversedBy="usuariosEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    protected $empresaRel;

    public function getRoles()
    {
        return array("ROLE_USER");
        // TODO: Implement getRoles() method.
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function serialize()
    {
        return serialize(array(
            $this->username,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
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
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin): void
    {
        $this->admin = $admin;
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
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * @param mixed $operacion
     */
    public function setOperacion($operacion): void
    {
        $this->operacion = $operacion;
    }
}
