<?php

namespace App\Repository;

use App\Controller\Mensajes;
use App\Entity\TteDestinatario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class TteDestinatarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TteDestinatario::class);
    }

    public function lista()
    {
        $em = $this->_em;
        $qb = $em->createQueryBuilder()
            ->from(TteDestinatario::class, 'd')
            ->leftJoin('d.ciudadRel', 'c')
            ->select('d.codigoDestinatarioPk')
            ->addSelect('d.numeroIdentificacion')
            ->addSelect('d.digitoVerificacion')
            ->addSelect('d.codigoIdentificacionTipoFk')
            ->addSelect('d.nombreCorto')
            ->addSelect('d.direccion')
            ->addSelect('c.nombre AS ciudadNombre')
            ->addSelect('d.telefono')
            ->where('d.codigoDestinatarioPk <> 0');
        return $qb;
    }

    public function buscar(){
        $em = $this->_em;
        $qb = $em->createQueryBuilder()
            ->from(TteDestinatario::class, 'd')
            ->leftJoin('d.ciudadRel', 'c')
            ->select('d.codigoDestinatarioPk')
            ->addSelect('d.numeroIdentificacion')
            ->addSelect('d.codigoCiudadFk')
            ->addSelect('d.digitoVerificacion')
            ->addSelect('d.codigoIdentificacionTipoFk')
            ->addSelect('d.nombreCorto')
            ->addSelect('d.direccion')
            ->addSelect('c.nombre AS ciudadNombre')
            ->addSelect('d.telefono')
            ->where('d.codigoDestinatarioPk <> 0');
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