<?php

namespace App\Repository;

use App\Entity\TteEmpresa;
use App\Entity\TteGuia;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;

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

    /**
     * @param $usuario Usuario
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista($usuario)
    {
        $session = new Session();
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
            ->addSelect('g.estadoImportado')
            ->from(TteGuia::class, 'g')
            ->leftJoin('g.ciudadDestinoRel', 'cd')
            ->leftJoin('g.ciudadOrigenRel', 'co')
            ->where('g.codigoGuiaPk <> 0')
        ->orderBy('g.fechaIngreso', 'DESC');
        if(!$usuario->getAdmin()) {
            $qb->andWhere('g.codigoEmpresaFk = '.$usuario->getCodigoEmpresaFk());
        }
        if($session->get('filtroGuiaFechaDesde')){
            $qb->andWhere("g.fecha >= '{$session->get('filtroGuiaFechaDesde')} 00:00:00'");
        }
        if($session->get('filtroGuiaFechaHasta')){
            $qb->andWhere("g.fecha <= '{$session->get('filtroGuiaFechaHasta')} 23:59:59'");
        }
        if($session->get('filtroGuiaNumero')){
            $qb->andWhere("g.numero = " . $session->get('filtroGuiaNumero'));
        }
        return $qb;
    }

    /**
     * @param $usuario Usuario
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function buscar($usuario)
    {
        $session = new Session();
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
            ->where('g.codigoDespachoFk IS NULL')
            ->andWhere('g.codigoEmpresaFk = '.$usuario->getCodigoEmpresaFk());
        if ($session->get('filtroGuiaCodigo')) {
            $qb->andWhere("g.codigoGuiaPk = {$session->get('filtroGuiaCodigo')}");
        }
        if ($session->get('filtroClienteDocumento')) {
            $qb->andWhere("g.clienteDocumento = '{$session->get('filtroClienteDocumento')}'");
        }
        if ($session->get('filtroGuiaNumero')) {
            $qb->andWhere("g.numero = {$session->get('filtroGuiaNumero')}");
        }
        return $qb;
    }

    /**
     * @param $codigoDespacho integer
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function despachoDetalles($codigoDespacho)
    {
        $qb = $this->_em->createQueryBuilder()->from(TteGuia::class, 'g')
            ->select('g.codigoGuiaPk')
            ->addSelect('g.numero')
            ->addSelect('cd.nombre as ciudadDestino')
            ->addSelect('g.clienteDocumento')
            ->addSelect('g.destinatarioNombre')
            ->addSelect('g.unidades')
            ->addSelect('g.pesoReal')
            ->addSelect('g.vrDeclara')
            ->addSelect('g.vrFlete')
            ->addSelect('g.vrManejo')
            ->leftJoin('g.ciudadDestinoRel', 'cd')
            ->where('g.codigoDespachoFk = ' . $codigoDespacho);
        return $qb;

    }

    /**
     * @param $codigoOperador
     * @param $arrFiltros
     * @return mixed
     */
    public function pendiente($codigoOperador, $arrFiltros)
    {
        $qb = $this->_em->createQueryBuilder()
            ->from(TteGuia::class, 'g')
            ->select('g.codigoGuiaPk')
            ->addSelect('g.numero')
            ->addSelect('g.fechaIngreso')
            ->addSelect('g.clienteDocumento')
            ->addSelect('e.nit')
            ->addSelect('g.destinatarioTelefono')
            ->addSelect('g.destinatarioDireccion')
            ->addSelect('g.destinatarioNombre')
            ->addSelect('co.nombre as ciudadOrigen')
            ->addSelect('cd.nombre as ciudadDestino')
            ->addSelect('co.codigoCiudadOperadorFk as codigoCiudadOrigenFk')
            ->addSelect('cd.codigoCiudadOperadorFk as codigoCiudadDestinoFk')
            ->addSelect('g.unidades')
            ->addSelect('g.codigoGuiaTipoFk')
            ->addSelect('g.operacion')
            ->addSelect('g.pesoFacturado')
            ->addSelect('g.pesoReal')
            ->addSelect('g.pesoVolumen')
            ->addSelect('g.vrDeclara')
            ->addSelect('g.vrFlete')
            ->addSelect('g.vrManejo')
            ->addSelect('g.comentario')
            ->leftJoin('g.ciudadDestinoRel', 'cd')
            ->leftJoin('g.ciudadOrigenRel', 'co')
            ->leftJoin('g.empresaRel', 'e')
            ->where("g.codigoOperadorFk = '{$codigoOperador}'")
            ->andWhere('g.estadoImportado = 0');
        if ($arrFiltros['fechaDesde'] != '') {
            $qb->andWhere("g.fechaIngreso >= '" . $arrFiltros['fechaDesde'] . " 00:00:00'");
        }
        if ($arrFiltros['fechaHasta'] != '') {
            $qb->andWhere("g.fechaIngreso <= '" . $arrFiltros['fechaHasta'] . " 23:59:59'");
        }
        if ($arrFiltros['nit'] != '') {
            $qb->andWhere("e.nit = '" . $arrFiltros['nit'] . "'");
        }
        return $qb->getQuery()->execute();
    }

    /**
     * @param $arrDatos
     * @return bool|
     */
    public function exportarGuia($arrDatos)
    {
        $respuesta = true;
        $qb = $this->_em->createQueryBuilder()
            ->update(TteGuia::class, 'g')
            ->set('g.estadoImportado', 1)
            ->where("g.codigoOperadorFk = '{$arrDatos['codigoOperador']}'")
            ->andWhere('g.numero IN (' . implode(',', $arrDatos['numeros']) . ')');
        try {
            $qb->getQuery()->getResult();
        } catch (\Exception $exception) {
            $respuesta = false;
        }
        return $respuesta;
    }
}
