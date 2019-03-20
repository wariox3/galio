<?php

namespace App\Controller\Informe;

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
     * @Route("/informe/guia/general", name="informe_guia_general")
     */
    public function lista(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => new \DateTime('now'), 'required' => true])
            ->add('fechaHasta', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => new \DateTime('now'), 'required' => true])
            ->add('txtNumero', TextType::class, ['data' => "", 'required' => false])
            ->add('txtDocumento', TextType::class, ['data' => "", 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        $arGuias = null;
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                if($this->getUser()->getCodigoOperadorFk() || $this->getUser()->getCodigoClienteFk()) {
                    $fechaDesde = $form->get('fechaDesde')->getData()->format('Y-m-d');
                    $fechaHasta = $form->get('fechaHasta')->getData()->format('Y-m-d');
                    $numero = $form->get('txtNumero')->getData();
                    $documento = $form->get('txtDocumento')->getData();
                    $arConfiguracion = $em->find(GenConfiguracion::class, 1);
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_POST => 1,
                        CURLOPT_URL => $arConfiguracion->getUrlCesio() . 'api/galio/guia/lista/cliente',
                        CURLOPT_POSTFIELDS => json_encode([
                            'codigoOperador' => $this->getUser()->getCodigoOperadorFk(),
                            'codigoCliente' => $this->getUser()->getCodigoClienteFk(),
                            'fechaDesde' => $fechaDesde,
                            'fechaHasta' => $fechaHasta,
                            'numero' => $numero,
                            'documento' => $documento
                        ])
                    ));
                    $arGuias = json_decode(curl_exec($curl), true);
                } else {
                    Mensajes::error("El usuario no tiene configurado operador o cliente");
                }
            }
        }

        return $this->render('informe/guia/general.html.twig', [
            'arGuias' => $arGuias,
            'form' => $form->createView()

        ]);
    }

}