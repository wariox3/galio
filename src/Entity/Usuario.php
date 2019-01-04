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
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */
    private $codigoEmpresaFk;

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
    public function getCodigoEmpresa()
    {
        return $this->codigoEmpresa;
    }

    /**
     * @param mixed $codigoEmpresa
     */
    public function setCodigoEmpresa($codigoEmpresa): void
    {
        $this->codigoEmpresa = $codigoEmpresa;
    }
}
