<?php

namespace App\Repository;


use App\Entity\TtePrecio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TtePrecioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TtePrecio::class);
    }

    public function lista(){
        $qb = $this->_em->createQueryBuilder()
            ->from(TtePrecio::class,'p')
            ->leftJoin('p.ciudadOrigenRel','co')
            ->leftJoin('p.ciudadDestinoRel','cd')
            ->leftJoin('p.productoRel','pr')
            ->select('p.codigoPrecioPk')
            ->addSelect('co.nombre as ciudadOrigen')
            ->addSelect('cd.nombre as ciudadDestino')
            ->addSelect('pr.nombre as producto')
            ->addSelect('p.vrKilo')
            ->addSelect('p.vrUnidad')
            ->where('p.codigoPrecioPk <> 0');
        return $qb;
    }
}
