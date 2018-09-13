<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class ConsultaGuiaController extends Controller
{
   /**
    * @Route("/consulta/guia/{operador}", name="consulta_guia")
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
                    //$direccion = "http://159.65.52.53/cesio/public/index.php";
                    $direccion = "http://localhost/cesio/public/index.php";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $direccion . "/api/localizador/guia/estado/" . $operador . "/" . $guia);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $response = curl_exec($ch);
                    $arrEstados = json_decode($response, true);
                    $arrEstados = $arrEstados['guias'];
                    $arrEstados['url'] = "http://190.85.62.78:8026/dts/descargarguia.php?guia=" . $guia;
                }
            }
        }
        return $this->render('consultaGuia.html.twig', [
            'operador' => $operador,
            'arrEstados' => $arrEstados,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cumplido/guia/{operador}/{guia}", name="cumplido_guia")
     */
    public function cumplido($operador="1", $guia = 0)
    {
        //$direccion = "http://159.65.52.53/cesio/public/index.php";
        $direccion = "http://localhost/cesio/public/index.php";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            //CURLOPT_URL => 'http://localhost/cromo/public/index.php/documental/api/registro/masivo/1',
            CURLOPT_URL => $direccion . '/api/localizador/guia/cumplido/' . $operador . "/" . $guia,
        ));
        $resp = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if ($resp && $resp['status'] == true) {
            $file = $resp['binary'];
            $type = $resp['type'];
            header('Content-Description: File Transfer');
            header("Content-Type: {$type}");
            header('Content-Disposition: attachment; filename=' . $guia . "." . $type);
            header("Content-Transfer-Encoding: base64");
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($file));
            readfile($file);
            exit;
        }
        return false;
    }

}

