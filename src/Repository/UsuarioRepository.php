<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    /**
     * @param $usuario Usuario
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista($usuario){
        return $this->_em->createQueryBuilder()->from(Usuario::class,'u')
            ->select('u.username')
            ->addSelect('u.codigoCiudadFk')
            ->addSelect('e.nombre as nombreEmpresa')
            ->addSelect('u.operacion')
            ->addSelect('u.codigoClienteFk')
            ->leftJoin('u.empresaRel','e')
            ->where("u.codigoOperadorFk = '{$usuario->getCodigoOperadorFk()}'");
    }
}
