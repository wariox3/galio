<?php

namespace App\Repository;


use App\Entity\TteEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TteEmpresaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TteEmpresa::class);
    }

    public function lista($operador){
        $qb = $this->_em->createQueryBuilder()
            ->from(TteEmpresa::class,'e')
            ->select('e.codigoEmpresaPk')
            ->addSelect('e.nombre')
            ->addSelect('e.nit')
            ->addSelect('e.direccion')
            ->addSelect('e.telefono')
            ->addSelect('e.consecutivoGuiaDesde as desde')
            ->addSelect('e.consecutivoGuia as consecutivo')
            ->addSelect('e.consecutivoGuiaHasta as hasta')
            ->where('e.codigoEmpresaPk <> 0')
        ->andWhere("e.codigoOperadorFk = '$operador'");
        return $qb;
    }
}
