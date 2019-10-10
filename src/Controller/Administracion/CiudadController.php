<?php

namespace App\Controller\Administracion;

use App\Controller\Mensajes;
use App\Entity\TteCiudad;
use App\Entity\TtePrecio;
use App\Entity\TteProducto;
use App\Form\Type\CiudadType;
use App\Form\Type\PrecioType;
use App\Form\Type\ProductoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CiudadController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/ciudad/lista", name="administracion_ciudad_lista")
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
        $arCiudades = $paginador->paginate($em->getRepository(TteCiudad::class)->lista($this->getUser()), $request->query->getInt('page', 1), 30);
        return $this->render('administracion/ciudad/lista.html.twig', [
            'arCiudades' => $arCiudades,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/ciudad/nuevo/{id}", name="administracion_ciudad_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCiudad = new TteCiudad();
        if ($id != '0') {
            $arCiudad = $em->find(TteCiudad::class, $id);
        }
        $form = $this->createForm(CiudadType::class, $arCiudad);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($arCiudad);
            $em->flush();
            return $this->redirect($this->generateUrl('administracion_ciudad_lista'));
        }
        return $this->render('administracion/ciudad/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

