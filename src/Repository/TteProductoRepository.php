<?php

namespace App\Repository;

use App\Entity\TteProducto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TteProductoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TteProducto::class);
    }

    public function lista($usuario){
        $qb = $this->_em->createQueryBuilder()
            ->select('p.nombre')
            ->addSelect('p.codigoProductoPk')
            ->addSelect('p.codigoOperadorFk')
            ->addSelect('p.orden')
            ->addSelect('p.codigoProductoOperadorFk')
            ->from(TteProducto::class,'p')
            ->where('p.codigoProductoPk IS NOT NULL')
            ->andWhere("p.codigoOperadorFk = '{$usuario->getCodigoOperadorFk()}'")
        ->orderBy('p.orden', 'ASC');
        return $qb;
    }
}
