<?php

namespace App\Controller\Buscar;

use App\Entity\TteCiudad;
use App\Entity\TteDestinatario;
use App\Entity\TteGuia;
use App\Form\Type\GuiaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class BuscarDestinatarioController extends Controller
{
    public $nombre;
    public $identificacion;
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/buscar/destinatario/lista/{campoNombre}/{campoCodigo}", name="buscar_destinatario_lista")
     */
    public function lista(Request $request, $campoNombre, $campoCodigo)
    {
        $em = $this->getDoctrine()->getManager();

        $paginador = $this->container->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('txtNombreCorto', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('txtNumeroIdentificacion', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary', 'style' => 'float:right;']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('btnFiltrar')->isClicked()){
                $this->nombre = $form->get('txtNombreCorto')->getData();
                $this->identificacion = $form->get('txtNumeroIdentificacion')->getData();
            }
        }
        $arDestinantarios = $paginador->paginate($em->getRepository(TteDestinatario::class)->buscar($this->getUser(),$this->nombre,$this->identificacion), $request->query->getInt('page', 1), 30);
        return $this->render('buscar/destinatario.html.twig', [
            'form' => $form->createView(),
            'campoNombre' => $campoNombre,
            'campoCodigo' => $campoCodigo,
            'arDestinatarios' => $arDestinantarios
        ]);
    }
}