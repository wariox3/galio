<?php

namespace App\Repository;

use App\Entity\TteProducto;
use App\Entity\TteProductoEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TteProductoEmpresaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TteProductoEmpresa::class);
    }

    public function lista($usuario, $id)
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('pe.codigoProductoEmpresaPk')
            ->addSelect('p.nombre AS producto')
            ->addSelect('pe.orden')
            ->from(TteProductoEmpresa::class, 'pe')
            ->where('pe.codigoProductoEmpresaPk IS NOT NULL')
            ->andWhere("p.codigoOperadorFk = '{$usuario->getCodigoOperadorFk()}'")
            ->andWhere("pe.codigoEmpresaFk = {$id}")
            ->leftJoin('pe.productoRel', 'p')
            ->orderBy('pe.orden', 'ASC');
        return $qb;
    }
}
