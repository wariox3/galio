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
    * @Route("/{operador}", name="inicio")
    */    
    public function inicio(Request $request, $operador)
    {
        $em = $this->getDoctrine()->getManager();
        $arrEstados = array();
        $form = $this->createFormBuilder()
            ->add('TxtGuia', TextType::class)
            ->add('BtnBuscar', SubmitType::class, array('label' => 'Buscar'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnBuscar')->isClicked()) {
                $guia = $form->get('TxtGuia')->getData();
                if($guia) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://159.65.52.53/cesio/public/index.php/api/localizador/guia/estado/" . $operador . "/" . $guia);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $response = curl_exec($ch);
                    $arrEstados = json_decode($response);
                }
            }
        }
        return $this->render('inicio.html.twig', [
            'operador' => $operador,
            'arrEstados' => $arrEstados,
            'form' => $form->createView()
        ]);
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

