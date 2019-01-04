<?php

namespace App\Controller\Movimiento;

use App\Entity\TteGuia;
use App\Form\Type\GuiaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuiaController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/guia/lista", name="movimiento_guia_lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->container->get('knp_paginator');
        $arGuia = [];
        $form = $this->createForm(GuiaType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $arGuia = $form->getData();
        }
        $arGuias = [];
        return $this->render('movimiento/guia/lista.html.twig',[
            'form' => $form->createView(),
            'arGuias' => $arGuias
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/guia/nuevo/{id}", name="movimiento_guia_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arGuia = new TteGuia();
        if($id != 0){
            $arGuia = $em->find(TteGuia::class,$id);
        }
        $form = $this->createForm(GuiaType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

        }
        return $this->render('movimiento/guia/nuevo.html.twig',[
            'form' => $form->createView()
        ]);
    }
}

