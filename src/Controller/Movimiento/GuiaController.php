<?php

namespace App\Controller\Movimiento;

use App\Controller\Mensajes;
use App\Entity\GenConfiguracion;
use App\Entity\TteCiudad;
use App\Entity\TteDestinatario;
use App\Entity\TteEmpresa;
use App\Entity\TteGuia;
use App\Entity\Usuario;
use App\Form\Type\GuiaType;
use App\Formato\Etiqueta;
use App\Formato\Guia;
use App\Formato\GuiaEnergy;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuiaController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @Route("/movimiento/guia/lista", name="movimiento_guia_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        $paginador = $this->container->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => $session->get('filtroGuiaFechaDesde') ? date_create($session->get('filtroGuiaFechaDesde')) : null, 'required' => false])
            ->add('fechaHasta', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => $session->get('filtroGuiaFechaHasta') ? date_create($session->get('filtroGuiaFechaHasta')) : null, 'required' => false])
            ->add('txtNumero', TextType::class, ['data' => $session->get('filtroGuiaNumero'), 'required' => false])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar'])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->get('OpImprimirEtiqueta')) {
                $codigoGuia = $request->request->get('OpImprimirEtiqueta');
                $objDespacho = new Etiqueta();
                $objDespacho->Generar($em, $codigoGuia);
            }
            if ($request->request->get('OpImprimirGuia')) {
                $codigoGuia = $request->request->get('OpImprimirGuia');
                $objGuia = new Guia();
                $objGuia->Generar($em, $codigoGuia);
            }
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroGuiaFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroGuiaFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $session->set('filtroGuiaNumero', $form->get('txtNumero')->getData());
            }
            if ($form->get('btnEliminar')->isClicked() && $usuario->getAdmin() == true) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(TteGuia::class)->eliminar($arrSeleccionados);
                return $this->redirect($this->generateUrl('movimiento_guia_lista'));
            }
        }
        $arGuias = $paginador->paginate($em->getRepository(TteGuia::class)->lista($this->getUser()), $request->query->getInt('page', 1), 30);
        return $this->render('movimiento/guia/lista.html.twig', [
            'form' => $form->createView(),
            'arUsuario' => $usuario,
            'arGuias' => $arGuias
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @Route("/movimiento/guia/detalle/{id}", name="movimiento_guia_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEmpresa =  $em->getRepository(TteEmpresa::class)->find($this->getUser()->getCodigoEmpresaFk());
        $paginador = $this->container->get('knp_paginator');
        $arGuia = $em->find(TteGuia::class, $id);
        $arrBotonImprimir = ['label' => 'Imprimir', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-secondary']];
        $arrBotonAnular = ['label' => 'Anular', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-danger']];
        $arrBotonImprimirEtiquetas = ['label' => 'Imprimir etiquetas', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-secondary']];
        $arrBotonReliquidar = ['label' => 'Re-liquidar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-secondary']];
        if ($arGuia->getEstadoAnulado() == 1) {
            $arrBotonAnular['disabled'] = true;
        }
        $form = $this->createFormBuilder()
            ->add('btnReliquidar', SubmitType::class, $arrBotonReliquidar)
            ->add('btnImprimir', SubmitType::class, $arrBotonImprimir)
            ->add('btnAnular', SubmitType::class, $arrBotonAnular)
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar'])
            ->add('btnImprimirEtiquetas', SubmitType::class, $arrBotonImprimirEtiquetas)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnImprimirEtiquetas')->isClicked()) {
                $objDespacho = new Etiqueta();
                $objDespacho->Generar($em, $id);
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $objFormato = new Guia();
                $objFormato->Generar($em, $id);
            }
            if ($form->get('btnAnular')->isClicked()) {
                $em->getRepository(TteGuia::class)->Anular($arGuia);
                return $this->redirect($this->generateUrl('movimiento_guia_detalle', ['id' => $id]));
            }
            if ($form->get('btnReliquidar')->isClicked()) {
                $em->getRepository(TteGuia::class)->liquidar($arGuia, $this->getUser()->getCodigoOperadorFk() ,$arEmpresa);
                $em->persist($arGuia);
                $em->flush();
            }
        }
        $arConfiguracion = $em->find(GenConfiguracion::class, 1);
        $url = $arConfiguracion->getUrlCesio() . 'api/localizador/guia/estado/' . $arGuia->getCodigoOperadorFk() . '/' . $arGuia->getNumero();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $estadoGuia = curl_exec($ch);
        curl_close($ch);
        $estadoGuia = json_decode($estadoGuia);
        $arGuiaEstado = null;
        if (!$estadoGuia->error) {
            $arGuiaEstado = $estadoGuia->guias;
        }

        return $this->render('movimiento/guia/detalle.html.twig', [
            'form' => $form->createView(),
            'arGuia' => $arGuia,
            'arGuiasEstado' => $arGuiaEstado,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/movimiento/guia/nuevo/{id}", name="movimiento_guia_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arEmpresa =  $em->getRepository(TteEmpresa::class)->find($this->getUser()->getCodigoEmpresaFk());
        $arGuia = new TteGuia();
        if ($id != 0) {
            $arGuia = $em->find(TteGuia::class, $id);
        } else {
            $arGuia->setEmpresaRel($this->getUser()->getEmpresaRel());
            $arGuia->setFecha(new \DateTime('now'));
            $arGuia->setFechaIngreso(new \DateTime('now'));
            $arGuia->setRemitente($this->getUser()->getEmpresaRel()->getNombre());
        }
        $form = $this->createForm(GuiaType::class, $arGuia);
        $form->handleRequest($request);

        /** @var  $arEmpresa TteEmpresa */
        $arEmpresa = $this->getUser()->getEmpresaRel();
        if ($arEmpresa->getConsecutivoGuiaHasta()) {
            if (($arEmpresa->getConsecutivoGuiaHasta() - $arEmpresa->getConsecutivoGuia()) < 0 || $arEmpresa->getConsecutivoGuia() < $arEmpresa->getConsecutivoGuiaDesde() || $arEmpresa->getConsecutivoGuia() > $arEmpresa->getConsecutivoGuiaHasta()) {
                Mensajes::error("Ya no tiene mas consecutivos, no puede crear mas guias, por favor solicitar mas remesas a su operador");
                return $this->redirect($this->generateUrl('movimiento_guia_lista'));
            } elseif (($arEmpresa->getConsecutivoGuiaHasta() - $arEmpresa->getConsecutivoGuia()) <= 30) {
                Mensajes::error("Por favor solicitar mas remesas a su operador");
            }
        } else {
            Mensajes::error('Por favor contactar al administrador y solicitar la configuracion del "consecutivo hasta" de las guias para su empresa');
            return $this->redirect($this->generateUrl('movimiento_guia_lista'));
        }
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('productoRel')->getData()) {
                /** @var  $arUsuario Usuario */
                $arUsuario = $this->getUser();
                $arCiudadOrigen = $em->getRepository(TteCiudad::class)->find($arUsuario->getCodigoCiudadFk());
                $arGuia->setUsuario($arUsuario->getUsername());
                $arGuia->setOperadorRel($this->getUser()->getOperadorRel());
                $arGuia->setCiudadOrigenRel($arCiudadOrigen);
                if ($arGuia->getCodigoDestinatarioFk()) {
                    $arGuia->setDestinatarioRel($em->find(TteDestinatario::class, $arGuia->getCodigoDestinatarioFk()));
                }

                if ($arGuia->getPesoReal() >= $arGuia->getPesoVolumen()) {
                    $pesoFacturar = $arGuia->getPesoReal();
                } else {
                    $pesoFacturar = $arGuia->getPesoVolumen();
                }
                $arGuia->setPesoFacturado($pesoFacturar);
                $arGuia->setOperacion($arUsuario->getOperacion());
                if ($id == 0) {
                    $arEmpresa = $em->getRepository(TteEmpresa::class)->find($arUsuario->getCodigoEmpresaFk());
                    $consecutivo = $arEmpresa->getConsecutivoGuia();
                    $arEmpresa->setConsecutivoGuia($consecutivo + 1);
                    $em->persist($arEmpresa);
                    $arGuia->setNumero($consecutivo);
                }
                $em->getRepository(TteGuia::class)->liquidar($arGuia, $this->getUser()->getCodigoOperadorFk(), $arEmpresa);
                $em->persist($arGuia);
                $em->flush();
                return $this->redirect($this->generateUrl('movimiento_guia_lista'));
            } else {
                Mensajes::error("Debe seleccionar un producto");
            }

        }
        return $this->render('movimiento/guia/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}