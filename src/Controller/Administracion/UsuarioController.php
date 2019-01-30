<?php

namespace App\Controller\Administracion;

use App\Controller\Mensajes;
use App\Entity\TteProducto;
use App\Entity\Usuario;
use App\Form\Type\ProductoType;
use App\Form\Type\UsuarioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsuarioController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/usuario/lista", name="administracion_usuario_lista")
     */
    public function lista(Request $request)
    {
        if (!$this->getUser()->getAdmin()) {
            Mensajes::error('Permiso denegado');
            return $this->render('error.html.twig');
        }
        $em = $this->getDoctrine()->getManager();
        $paginador = $this->container->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                if ($arrSeleccionados) {
                    foreach ($arrSeleccionados as $username) {
                        $arUsuario = $em->find(Usuario::class, $username);
                        if ($arUsuario) {
                            $em->remove($arUsuario);
                        }
                    }
                    try{
                        $em->flush();
                        Mensajes::success('Usuario eliminado correctamente');
                    } catch (\Exception $exception){
                        Mensajes::error('Ha ocurrido un error al momento de eliminar el usuario, porfavor contacte con soporte tecnico');
                    }
                }
            }
        }
        $arUsuarios = $paginador->paginate($em->getRepository(Usuario::class)->lista($this->getUser()), $request->query->getInt('page', 1), 80);
        return $this->render('administracion/usuario/lista.html.twig', [
            'arUsuarios' => $arUsuarios,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/administracion/usuario/nuevo/{id}", name="administracion_usuario_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arUsuario = new Usuario();
        if ($id != '0') {
            $arUsuario = $em->find(Usuario::class, $id);
        } else {
            $arUsuario->setCodigoOperadorFk($this->getUser()->getCodigoOperadorFk());
        }
        $form = $this->createForm(UsuarioType::class, $arUsuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($arUsuario);
            $em->flush();
            return $this->redirect($this->generateUrl('administracion_usuario_lista'));
        }
        return $this->render('administracion/usuario/nuevo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

