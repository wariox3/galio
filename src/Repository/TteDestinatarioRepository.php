<?php

namespace App\Repository;

use App\Controller\Mensajes;
use App\Entity\TteDestinatario;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TteDestinatarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TteDestinatario::class);
    }

    /**
     * @param $usuario Usuario
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista($usuario)
    {
        $em = $this->_em;
        $qb = $em->createQueryBuilder()
            ->from(TteDestinatario::class, 'd')
            ->leftJoin('d.ciudadRel', 'c')
            ->select('d.codigoDestinatarioPk')
            ->addSelect('d.numeroIdentificacion')
            ->addSelect('d.digitoVerificacion')
            ->addSelect('d.nombreCorto')
            ->addSelect('d.direccion')
            ->addSelect('c.nombre AS ciudadNombre')
            ->addSelect('d.telefono')
            ->where('d.codigoDestinatarioPk <> 0')
            ->andWhere('d.codigoEmpresaFk = ' . $usuario->getCodigoEmpresaFk());
        return $qb;
    }

    /**
     * @param $usuario Usuario
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function buscar($usuario, $nombre, $identificacion)
    {
        $em = $this->_em;
        $qb = $em->createQueryBuilder()
            ->from(TteDestinatario::class, 'd')
            ->leftJoin('d.ciudadRel', 'c')
            ->select('d.codigoDestinatarioPk')
            ->addSelect('d.numeroIdentificacion')
            ->addSelect('d.codigoCiudadFk')
            ->addSelect('d.digitoVerificacion')
            ->addSelect('d.nombreCorto')
            ->addSelect('d.direccion')
            ->addSelect('c.nombre AS ciudadNombre')
            ->addSelect('d.telefono')
            ->where('d.codigoDestinatarioPk <> 0')
            ->andWhere('d.codigoEmpresaFk = ' . $usuario->getCodigoEmpresaFk());
        if($nombre){
            $qb->andWhere("d.nombreCorto LIKE '%{$nombre}%'");
        }
        if($identificacion){
            $qb->andWhere('d.numeroIdentificacion = '.$identificacion);
        }
        return $qb;
    }

    /**
     * @param $arrSeleccionados
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function eliminar($arrSeleccionados)
    {
        $em = $this->_em;
        foreach ($arrSeleccionados as $codigoDestinatario) {
            $arDestinatario = $em->find(TteDestinatario::class, $codigoDestinatario);
            if ($arDestinatario) {
                $em->remove($arDestinatario);
            }
        }
        try {
            $em->flush();
            Mensajes::success('Registros eliminados correctamente');
        } catch (\Exception $exception) {
            if ($exception) {
                Mensajes::error('Algunos registros ya se encuentran en uso');
            }
        }
    }
}