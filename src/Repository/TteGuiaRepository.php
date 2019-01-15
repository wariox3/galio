<?php

namespace App\Repository;

use App\Entity\TteEmpresa;
use App\Entity\TteGuia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TteGuiaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TteGuia::class);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function consecutivo($id)
    {
        $em = $this->getEntityManager();
        $arEmpresa = $em->getRepository(TteEmpresa::class)->find($id);
        $consecutivo = $arEmpresa->getConsecutivoGuia();
        $arEmpresa->setConsecutivoGuia($consecutivo + 1);
        $em->persist($arEmpresa);
        $em->flush();
        return $consecutivo;
    }

    public function lista()
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('g.codigoGuiaPk')
            ->addSelect('g.numero')
            ->addSelect('g.fechaIngreso')
            ->addSelect('g.clienteDocumento')
            ->addSelect('g.destinatarioNombre')
            ->addSelect('cd.nombre as ciudadDestino')
            ->addSelect('co.nombre as ciudadOrigen')
            ->addSelect('g.unidades')
            ->addSelect('g.pesoFacturado')
            ->addSelect('g.vrDeclara')
            ->addSelect('g.vrFlete')
            ->addSelect('g.vrManejo')
            ->from(TteGuia::class, 'g')
            ->leftJoin('g.ciudadDestinoRel', 'cd')
            ->leftJoin('g.ciudadOrigenRel', 'co')
            ->where('g.codigoGuiaPk <> 0');
        return $qb;
    }
}
