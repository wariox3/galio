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

    public function lista(){
        $qb = $this->_em->createQueryBuilder()
            ->select('p.nombre')
            ->addSelect('p.codigoProductoPk')
            ->from(TteProducto::class,'p')
            ->where('p.codigoProductoPk <> 0');
        return $qb;
    }
}
