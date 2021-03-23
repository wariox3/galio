<?php

namespace App\Repository;


use App\Controller\Mensajes;
use App\Entity\TteEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TteEmpresaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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
        ->andWhere("e.codigoOperadorFk = '$operador'")
        ->orderBy('e.nombre', 'ASC');
        return $qb;
    }

    public function validarNumeroIdentificacionEmpresa($ar)
    {
        if ($ar) {
            if ($ar->getCodigoEmpresaPk()) {
                $queryBuilder = $this->_em->createQueryBuilder()->from(TteEmpresa::class, 'e')
                    ->select('e.codigoEmpresaPk')
                    ->where("e.nit = {$ar->getNit()}")
                    ->andWhere("e.codigoEmpresaPk <> {$ar->getCodigoEmpresaPk()}");
                $ar = $queryBuilder->getQuery()->getResult();
            } else {
                $ar = $this->_em->getRepository(TteEmpresa::class)->findBy(['nit' => $ar->getNit()]);
            }
            if (!$ar) {
                return true;
            } else {
                Mensajes::error("Ya existe una empresa con el mismo nit");
                return false;
            }
        } else {
            Mensajes::error("Es necesario el nit");
            return false;
        }

    }
}
