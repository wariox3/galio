<?php

namespace App\Controller\Administracion;

use App\Controller\Mensajes;
use App\Entity\TtePrecio;
use App\Entity\TteProducto;
use App\Form\Type\PrecioType;
use App\Form\Type\ProductoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductoController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/producto/lista", name="administracion_producto_lista")
     */
    public function lista(Request $request)
    {
        if(!$this->getUser()->getAdmin()){
            Mensajes::error('Permiso denegado');
            return $this->render('error.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->container->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('btnEliminar')
            ->getForm();
        $form->handleRequest($request);
        $arProductos = $paginador->paginate($em->getRepository(TteProducto::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('administracion/producto/lista.html.twig', [
            'arProductos' => $arProductos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/producto/nuevo/{id}", name="administracion_producto_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arProducto = new TteProducto();
        if ($id != '0') {
            $arProducto = $em->find(TteProducto::class, $id);
        }
        $form = $this->createForm(ProductoType::class, $arProducto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($arProducto);
            $em->flush();
            return $this->redirect($this->generateUrl('administracion_producto_lista'));
        }
        return $this->render('administracion/producto/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

