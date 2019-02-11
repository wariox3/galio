<?php

namespace App\Repository;

use App\Entity\TteDespacho;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class TteDespachoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TteDespacho::class);
    }

    /**
     * @param $usuario Usuario
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista($usuario){
        $session = new Session();
        $qb = $this->_em->createQueryBuilder()
            ->select('d.codigoDespachoPk')
            ->addSelect('d.fecha')
            ->addSelect('d.guias')
            ->addSelect('d.unidades')
            ->addSelect('d.peso')
            ->addSelect('d.vrDeclara')
            ->addSelect('d.estadoImpreso')
            ->from(TteDespacho::class,'d')
            ->where('d.codigoDespachoPk <> 0');
        if(!$usuario->getAdmin()) {
            $qb->andWhere('d.codigoEmpresaFk = '.$usuario->getCodigoEmpresaFk());
        }
        if($session->get('filtroDespachoFechaDesde')){
            $qb->andWhere("d.fecha >= '{$session->get('filtroDespachoFechaDesde')}'");
        }
        if($session->get('filtroDespachoFechaHasta')){
            $qb->andWhere("d.fecha <= '{$session->get('filtroDespachoFechaHasta')}'");
        }
        return $qb;
    }

    /**
     * @param $arDespacho TteDespacho
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function aprobar($arDespacho)
    {
        $arDespacho->setEstadoAprobado(1);
        $this->getEntityManager()->persist($arDespacho);
        $this->getEntityManager()->flush();
    }
}