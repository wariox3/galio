<?php

namespace App\Controller\Administracion;

use App\Entity\TtePrecio;
use App\Form\Type\PrecioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PrecioController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/precio/lista", name="administracion_precio_lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->container->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('btnEliminar')
            ->getForm();
        $form->handleRequest($request);
        $arPrecios = $paginador->paginate($em->getRepository(TtePrecio::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('administracion/precio/lista.html.twig', [
            'arPrecios' => $arPrecios,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/precio/nuevo/{id}", name="administracion_precio_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arPrecio = new TtePrecio();
        if ($id != 0) {
            $arPrecio = $em->find(TtePrecio::class, $id);
        }
        $form = $this->createForm(PrecioType::class, $arPrecio);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($arPrecio);
            $em->flush();
            return $this->redirect($this->generateUrl('administracion_precio_lista'));
        }
        return $this->render('administracion/precio/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

