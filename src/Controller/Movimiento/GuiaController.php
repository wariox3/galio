<?php

namespace App\Controller\Movimiento;

use App\Entity\GenConfiguracion;
use App\Entity\TteCiudad;
use App\Entity\TteDestinatario;
use App\Entity\TteGuia;
use App\Entity\Usuario;
use App\Form\Type\GuiaType;
use App\Formato\Etiqueta;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
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
        $paginador = $this->container->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger float-right']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->get('OpImprimirEtiqueta')) {
                $codigoGuia = $request->request->get('OpImprimirEtiqueta');
                $objDespacho = new Etiqueta();
                $objDespacho->Generar($em, $codigoGuia);
            }
        }
        $arGuias = $paginador->paginate($em->getRepository(TteGuia::class)->lista(), $request->query->getInt('page', 1), 30);
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

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var  $arUsuario Usuario */
            $arUsuario = $this->getUser();
            $arCiudadOrigen = $em->getRepository(TteCiudad::class)->find($arUsuario->getCodigoCiudadFk());
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
                $ch = curl_init($arConfiguracion->getUrlCesio() . 'api/precio/calcular/' . $arGuia->getCiudadOrigenRel()->getCodigoCiudadPk() . '/' . $arGuia->getCiudadDestinoRel()->getCodigoCiudadPk() . '/' . $arGuia->getProductoRel()->getCodigoProductoPk() . '/' . $arGuia->getPesoFacturado() . '/' . $arUsuario->getCodigoOperadorFk() . '/' . $arGuia->getEmpresaRel()->getListaPrecio());
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