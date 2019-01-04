<?php

namespace App\Controller\Movimiento;

use App\Form\Type\GuiaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DespachoController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/despacho/lista", name="movimiento_despacho_lista")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arGuia = [];
        $form = $this->createForm(GuiaType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $arGuia = $form->getData();
        }
        return $this->render('transporte/despacho/nuevo.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/despacho/nuevo", name="movimiento_despacho_nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arGuia = [];
        $form = $this->createForm(GuiaType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $arGuia = $form->getData();
        }
        return $this->render('transporte/despacho/nuevo.html.twig',[
            'form' => $form->createView()
        ]);
    }
}

