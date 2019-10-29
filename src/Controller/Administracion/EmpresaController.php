<?php

namespace App\Controller\Administracion;

use App\Controller\Mensajes;
use App\Entity\TteDestinatario;
use App\Entity\TteEmpresa;
use App\Entity\TteProducto;
use App\Form\Type\EmpresaType;
use App\Form\Type\ProductoEmpresaType;
use App\Form\Type\ProductoType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmpresaController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/empresa/lista", name="administracion_empresa_lista")
     */
    public function lista(Request $request)
    {
        if (!$this->getUser()->getAdmin()) {
            Mensajes::error('Permiso denegado');
            return $this->render('error.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->container->get('knp_paginator');
        $arEmpresas = $paginador->paginate($em->getRepository(TteEmpresa::class)->lista($this->getUser()->getCodigoOperadorFk()), $request->query->getInt('page', 1), 100);
        return $this->render('administracion/empresa/lista.html.twig', [
            'arEmpresas' => $arEmpresas
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/empresa/nuevo/{id}", name="administracion_empresa_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEmpresa = new TteEmpresa();
        if ($id != 0) {
            $arEmpresa = $em->find(TteEmpresa::class, $id);
        } else {
            $arEmpresa->setConsecutivoGuia(1);
            $arEmpresa->setConsecutivoGuiaHasta(100);
        }
        $form = $this->createForm(EmpresaType::class, $arEmpresa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arEmpresa->setCodigoOperadorFk($this->getUser()->getCodigoOperadorFk());
            $em->persist($arEmpresa);
            $em->flush();
            return $this->redirect($this->generateUrl('administracion_empresa_lista'));
        }
        return $this->render('administracion/empresa/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/empresa/detalle/{id}", name="administracion_empresa_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $paginador = $this->container->get('knp_paginator');
        $arEmpresa = $em->find(TteEmpresa::class, $id);
        $form = $this->createFormBuilder()
            ->add('btnEliminarDetalle', SubmitType::class, array('label' => 'Eliminar'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEliminarDetalle')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(TteProducto::class)->eliminar($arrSeleccionados);

                return $this->redirect($this->generateUrl('administracion_empresa_detalle', array('id' => $id)));
            }
        }
        $arProductos = $paginador->paginate($em->getRepository(TteProducto::class)->lista($id), $request->query->getInt('page', 1), 30);
        return $this->render('administracion/empresa/detalle.html.twig', [
            'form' => $form->createView(),
            'arEmpresa' => $arEmpresa,
            'arProductos' => $arProductos
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/empresa/detalle/nuevo/{codigoEmpresa}/{id}", name="administracion_empresa_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $codigoEmpresa, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arProducto = New TteProducto();
        $arEmpresa = $em->getRepository(TteEmpresa::class)->find($codigoEmpresa);
        if ($id != '0') {
            $arProducto = $em->getRepository(TteProducto::class)->find($id);
        } else {

        }
        $form = $this->createForm(ProductoType::class, $arProducto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arProducto->setEmpresaRel($arEmpresa);
                $em->persist($arProducto);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";

            }
        }
        return $this->render('administracion/empresa/detalleNuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

