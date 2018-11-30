<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class InicioController extends Controller
{

    /**
     * @Route("/", name="inicio")
     */
    public function inicio(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/informacion", name="informacion")
     */
    public function informacion(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('informacion.html.twig');
    }
}

