<?php

namespace App\Controller\Administracion;

use App\Controller\Mensajes;
use App\Entity\TteDestinatario;
use App\Entity\TteGuia;
use App\Form\Type\DestinatarioType;
use App\Form\Type\GuiaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DestinatarioController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @Route("/administracion/destinatario/lista", name="administracion_destinatario_lista")
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
            ->add('btnEliminar',SubmitType::class,['label' => 'Eliminar','attr' => ['class' => 'btn btn-sm btn-danger float-right']])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($form->get('btnEliminar')->isClicked()){
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                if($arrSeleccionados){
                    $em->getRepository(TteDestinatario::class)->eliminar($arrSeleccionados);
                }
            }
            return $this->redirect($this->generateUrl('administracion_destinatario_lista'));
        }
        $arDestinatarios = $paginador->paginate($em->getRepository(TteDestinatario::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('administracion/destinatario/lista.html.twig', [
            'arDestinatarios' => $arDestinatarios,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/destinatario/nuevo/{id}", name="administracion_destinatario_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arDestinatario = new TteDestinatario();
        if ($id != 0) {
            $arDestinatario  = $em->find(TteDestinatario::class, $id);
        }
        $form = $this->createForm(DestinatarioType::class, $arDestinatario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arDestinatario->setEmpresaRel($this->getUser()->getEmpresaRel());
            $em->persist($arDestinatario);
            $em->flush();
            return $this->redirect($this->generateUrl('administracion_destinatario_lista'));
        }
        return $this->render('administracion/destinatario/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

