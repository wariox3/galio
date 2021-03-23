<?php

namespace App\Repository;

use App\Entity\TteCiudad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TteCiudadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TteCiudad::class);
    }

    public function lista($usuario){
        $qb = $this->_em->createQueryBuilder()
            ->select('c.nombre')
            ->addSelect('d.nombre AS departamento')
            ->addSelect('c.codigoCiudadPk')
            ->addSelect('c.codigoOperadorFk')
            ->addSelect('c.codigoCiudadOperadorFk')
            ->from(TteCiudad::class,'c')
            ->leftJoin('c.departamentoRel', 'd')
            ->where('c.codigoCiudadPk IS NOT NULL')
            ->andWhere("c.codigoOperadorFk = '{$usuario->getCodigoOperadorFk()}'")
            ->orderBy('c.codigoCiudadPk', 'ASC');
        return $qb;
    }
}