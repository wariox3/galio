<?php

namespace App\Repository;

use App\Entity\TteProducto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TteProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TteProducto::class);
    }

    public function lista($codigoEmpresa){
        $qb = $this->_em->createQueryBuilder()
            ->select('p.nombre')
            ->addSelect('p.codigoProductoPk')
            ->addSelect('p.codigoOperadorFk')
            ->addSelect('p.orden')
            ->addSelect('p.codigoProductoOperadorFk')
            ->from(TteProducto::class,'p')
            ->where('p.codigoProductoPk IS NOT NULL')
            ->andWhere("p.codigoEmpresaFk = '{$codigoEmpresa}'")
        ->orderBy('p.orden', 'ASC');
        return $qb;
    }

    public function eliminar($arrSeleccionados)
    {
        $em = $this->getEntityManager();
        if ($arrSeleccionados) {
            foreach ($arrSeleccionados as $codigoRegistro) {
                $arRegistro = $em->getRepository(TteProducto::class)->find($codigoRegistro);
                if ($arRegistro) {
                    $em->remove($arRegistro);
                }
            }
            $em->flush();
        }
    }
}
