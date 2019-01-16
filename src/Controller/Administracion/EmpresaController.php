<?php

namespace App\Controller\Administracion;

use App\Entity\TteDestinatario;
use App\Entity\TteEmpresa;
use App\Form\Type\EmpresaType;
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
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->container->get('knp_paginator');
        $arEmpresas = $paginador->paginate($em->getRepository(TteEmpresa::class)->lista(), $request->query->getInt('page', 1), 30);
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
            $arEmpresa  = $em->find(TteEmpresa::class, $id);
        }
        $form = $this->createForm(EmpresaType::class, $arEmpresa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($arEmpresa);
            $em->flush();
            return $this->redirect($this->generateUrl('administracion_empresa_lista'));
        }
        return $this->render('administracion/empresa/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
