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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $paginador = $this->container->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => $session->get('filtroGuiaFechaDesde') ? date_create($session->get('filtroGuiaFechaDesde')) : null, 'required' => false])
            ->add('fechaHasta', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => $session->get('filtroGuiaFechaHasta') ? date_create($session->get('filtroGuiaFechaHasta')) : null, 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->get('OpImprimirEtiqueta')) {
                $codigoGuia = $request->request->get('OpImprimirEtiqueta');
                $objDespacho = new Etiqueta();
                $objDespacho->Generar($em, $codigoGuia);
            }
            if($form->get('btnFiltrar')->isClicked()){
                $session->set('filtroGuiaFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroGuiaFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
            }
        }
        $arGuias = $paginador->paginate($em->getRepository(TteGuia::class)->lista($this->getUser()), $request->query->getInt('page', 1), 30);
        return $this->render('movimiento/guia/lista.html.twig', [
            'form' => $form->createView(),
            'arGuias' => $arGuias
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
        $arGuia = new TteGuia();
        if ($id != 0) {
            $arGuia = $em->find(TteGuia::class, $id);
        } else {
            $arGuia->setEmpresaRel($this->getUser()->getEmpresaRel());
            $arGuia->setFecha(new \DateTime('now'));
            $arGuia->setFechaIngreso(new \DateTime('now'));
        }
        $form = $this->createForm(GuiaType::class, $arGuia);
        $form->handleRequest($request);
        /** @var  $arEmpresa TteEmpresa */
        $arEmpresa = $this->getUser()->getEmpresaRel();
        if ($arEmpresa->getConsecutivoGuiaHasta()) {
            if (($arEmpresa->getConsecutivoGuiaHasta() - $arEmpresa->getConsecutivoGuia()) <= 0) {
                Mensajes::error("Ya no tiene mas consecutivos, no puede crear mas guias, por favor solicitar mas remesas a sistemas@cotrascalsas.com");
                return $this->redirect($this->generateUrl('movimiento_guia_lista'));
            } elseif (($arEmpresa->getConsecutivoGuiaHasta() - $arEmpresa->getConsecutivoGuia()) <= 50) {
                Mensajes::error("Por favor solicitar mas remesas a sistemas@cotrascalsas.com");
                return $this->redirect($this->generateUrl('movimiento_guia_lista'));
            }
        } else {
            Mensajes::error('Por favor contactar a sistemas@cotrascalsas.com y solicitar la configuracion del "consecutivo hasta" de las guias para su empresa');
            return $this->redirect($this->generateUrl('movimiento_guia_lista'));
        }
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var  $arUsuario Usuario */
            $arUsuario = $this->getUser();
            $arCiudadOrigen = $em->getRepository(TteCiudad::class)->find($arUsuario->getCodigoCiudadFk());
            $arGuia->setUsuario($arUsuario->getUsername());
            $arGuia->setCiudadOrigenRel($arCiudadOrigen);
            $arGuia->setDestinatarioRel($em->find(TteDestinatario::class, $arGuia->getCodigoDestinatarioFk()));
            $manejo = $arGuia->getEmpresaRel()->getPorcentajeManejo() * $arGuia->getVrDeclara() / 100;
            if ($arGuia->getEmpresaRel()->getManejoMinimoDespacho() > $manejo) {
                $manejo = $arGuia->getEmpresaRel()->getManejoMinimoDespacho();
            }
            $arGuia->setVrManejo(round($manejo));
            if ($arGuia->getPesoReal() >= $arGuia->getPesoVolumen()) {
                $pesoFacturar = $arGuia->getPesoReal();
            } else {
                $pesoFacturar = $arGuia->getPesoVolumen();
            }
            $arGuia->setPesoFacturado($pesoFacturar);
            $arGuia->setOperacion($arUsuario->getOperacion());
            $flete = 0;
            if ($pesoFacturar > 0) {
                $arConfiguracion = $em->find(GenConfiguracion::class, 1);
                $ch = curl_init($arConfiguracion->getUrlCesio() . 'api/precio/calcular/' . $arGuia->getCiudadOrigenRel()->getCodigoCiudadOperadorFk() . '/' . $arGuia->getCiudadDestinoRel()->getCodigoCiudadOperadorFk() . '/' . $arGuia->getProductoRel()->getCodigoProductoPk() . '/' . $arGuia->getPesoFacturado() . '/' . $arUsuario->getCodigoOperadorFk() . '/' . $arGuia->getEmpresaRel()->getListaPrecio());
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $flete = json_decode(curl_exec($ch));
                curl_close($ch);
            }
            $arGuia->setVrFlete(round($flete));
            if ($id == 0) {
                $consecutivo = $em->getRepository(TteGuia::class)->consecutivo($arGuia->getEmpresaRel()->getCodigoEmpresaPk());
                $arGuia->setNumero($consecutivo);
            }
            $em->persist($arGuia);
            $em->flush();
            return $this->redirect($this->generateUrl('movimiento_guia_lista'));
        }
        return $this->render('movimiento/guia/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}