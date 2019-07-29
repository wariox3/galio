<?php

namespace App\Controller\Movimiento;

use App\Entity\TteDespacho;
use App\Entity\TteGuia;
use App\Form\Type\DespachoType;
use App\Formato\Despacho;
use App\Formato\Etiqueta;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->container->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => $session->get('filtroDespachoFechaDesde') ? date_create($session->get('filtroDespachoFechaDesde')) : null, 'required' => false])
            ->add('fechaHasta', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => $session->get('filtroDespachoFechaHasta') ? date_create($session->get('filtroDespachoFechaHasta')) : null, 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session->set('filtroDespachoFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
            $session->set('filtroDespachoFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
        }
        $arDespachos = $paginador->paginate($em->getRepository(TteDespacho::class)->lista($this->getUser()), $request->query->getInt('page', 1), 30);
        return $this->render('movimiento/despacho/lista.html.twig', [
            'form' => $form->createView(),
            'arDespachos' => $arDespachos
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/despacho/nuevo/{id}", name="movimiento_despacho_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arDespacho = new TteDespacho();
        if ($id != 0) {
            $arDespacho = $em->find(TteDespacho::class, $id);
        } else {
            $arDespacho->setFecha(new \DateTime('now'));
            $arDespacho->setEmpresaRel($this->getUser()->getEmpresaRel());
            $arDespacho->setCodigoOperadorFk($this->getUser()->getCodigoOperadorFk());
        }
        $form = $this->createForm(DespachoType::class, $arDespacho);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($arDespacho);
            $em->flush();
            return $this->redirect($this->generateUrl('movimiento_despacho_lista'));
        }
        return $this->render('movimiento/despacho/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @Route("/movimiento/despacho/detalle/{id}", name="movimiento_despacho_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->container->get('knp_paginator');
        $arDespacho = $em->find(TteDespacho::class, $id);
        $arrBotonImprimir = ['label' => 'Imprimir', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-secondary']];
        $arrBotonAprobar = ['label' => 'Aprobar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-secondary']];
        $arrBotonAnular = ['label' => 'Anular', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-danger']];
        $arrBotonImprimirEtiquetas = ['label' => 'Imprimir etiquetas', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-secondary']];
        $arrBotonDetalleEliminar = ['label' => 'Eliminar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-danger float-right']];
        if ($arDespacho->getEstadoAprobado() == 1) {
            $arrBotonDetalleEliminar['disabled'] = true;
            $arrBotonAprobar['disabled'] = true;
            $arrBotonImprimir['disabled'] = false;
            $arrBotonAnular['disabled'] = false;
            if($arDespacho->getEstadoAnulado() == 1){
                $arrBotonAnular['disabled'] = true;
            }
        }
        $form = $this->createFormBuilder()
            ->add('btnImprimir', SubmitType::class, $arrBotonImprimir)
            ->add('btnAprobar', SubmitType::class, $arrBotonAprobar)
            ->add('btnAnular', SubmitType::class, $arrBotonAnular)
            ->add('btnImprimirEtiquetas', SubmitType::class, $arrBotonImprimirEtiquetas)
            ->add('btnDetalleEliminar', SubmitType::class, $arrBotonDetalleEliminar)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnImprimirEtiquetas')->isClicked()) {
                $objFormato = new Etiqueta();
                $objFormato->Generar($em, '', $id);
            }
            if ($form->get('btnDetalleEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                foreach ($arrSeleccionados as $codigoGuia) {
                    $arGuia = $em->find(TteGuia::class, $codigoGuia);
                    if($arGuia){
                        $arGuia->setCodigoDespachoFk(null);
                        $arGuia->setDespachoRel(null);
                        $em->persist($arGuia);
                    }
                }
                $em->flush();
                return $this->redirect($this->generateUrl('movimiento_despacho_detalle',['id' => $id]));
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $objFormato = new Despacho();
                $objFormato->Generar($em, $id, $this->getUser()->getCodigoOperadorFk());
            }
            if ($form->get('btnAprobar')->isClicked()) {
                $em->getRepository(TteDespacho::class)->Aprobar($arDespacho);
                return $this->redirect($this->generateUrl('movimiento_despacho_detalle', ['id' => $id]));
            }
            if ($form->get('btnAnular')->isClicked()) {
                $em->getRepository(TteDespacho::class)->Anular($arDespacho);
                return $this->redirect($this->generateUrl('movimiento_despacho_detalle', ['id' => $id]));
            }
        }
        $arGuias = $paginador->paginate($em->getRepository(TteGuia::class)->despachoDetalles($id), $request->query->getInt('page', 1), 30);
        return $this->render('movimiento/despacho/detalle.html.twig', [
            'form' => $form->createView(),
            'arDespacho' => $arDespacho,
            'arGuias' => $arGuias
        ]);
    }

    /**
     * @param Request $request
     * @param $codigoDespacho
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/despacho/guia/{codigoDespacho}", name="movimiento_despacho_guia")
     */
    public function agregarGuia(Request $request, $codigoDespacho)
    {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $paginador = $this->container->get('knp_paginator');
        $arDespacho = $em->find(TteDespacho::class, $codigoDespacho);
        $form = $this->createFormBuilder()
            ->add('txtGuiaCodigo', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control'], 'data' => $session->get('filtroGuiaCodigo')])
            ->add('txtClienteDocumento', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control'], 'data' => $session->get('filtroClienteDocumento')])
            ->add('txtGuiaNumero', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control'], 'data' => $session->get('filtroGuiaNumero')])
            ->add('btnGuardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-secondary float-right']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary  float-right']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                if ($arrSeleccionados) {
                    $cantGuias = $arDespacho->getGuias();
                    $unidades = $arDespacho->getUnidades();
                    $pesoTotal = $arDespacho->getPeso();
                    $pesoVolumenTotal = $arDespacho->getPesoVolumen();
                    $vrDeclaraTotal = $arDespacho->getVrDeclara();
                    foreach ($arrSeleccionados as $codigoGuia) {
                        $arGuia = $em->find(TteGuia::class, $codigoGuia);
                        $cantGuias++;
                        $unidades += $arGuia->getUnidades();
                        $pesoTotal += $arGuia->getPesoReal();
                        $pesoVolumenTotal += $arGuia->getPesoVolumen();
                        $vrDeclaraTotal += $arGuia->getVrDeclara();
                        if ($arGuia) {
                            $arGuia->setDespachoRel($arDespacho);
                        }
                        $em->persist($arGuia);
                    }
                    $arDespacho->setGuias($cantGuias);
                    $arDespacho->setUnidades($unidades);
                    $arDespacho->setPeso($pesoTotal);
                    $arDespacho->setPesoVolumen($pesoVolumenTotal);
                    $arDespacho->setVrDeclara($vrDeclaraTotal);
                    $em->persist($arDespacho);
                }
                $em->flush();
                echo "<script language='Javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroGuiaCodigo', $form->get('txtGuiaCodigo')->getData());
                $session->set('filtroClienteDocumento', $form->get('txtClienteDocumento')->getData());
                $session->set('filtroGuiaNumero', $form->get('txtGuiaNumero')->getData());
            }
        }
        $arGuias = $paginador->paginate($em->getRepository(TteGuia::class)->buscar($this->getUser()), $request->query->getInt('page', 1), 30);
        return $this->render('movimiento/despacho/agregarGuia.html.twig', [
            'form' => $form->createView(),
            'arGuias' => $arGuias
        ]);
    }
}

