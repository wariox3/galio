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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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
            ->add('btnExcel', SubmitType::class, ['label' => 'Excel', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        $arGuias = null;
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked() || $form->get('btnExcel')->isClicked()) {
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
            if ($form->get('btnExcel')->isClicked()) {
                if($arGuias){
                    set_time_limit(0);
                    ini_set("memory_limit", -1);
                    if (count($arGuias) > 0) {
                        $spreadsheet = new Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();
                        $j = 0;
                        //Se obtienen las columnas del archivo
                        $arrColumnas = array_keys($arGuias[0]);
                        for ($i = 'A'; $j <= sizeof($arrColumnas) - 1; $i++) {
                            $sheet->getColumnDimension($i)->setAutoSize(true);
                            $sheet->getStyle(1)->getFont()->setBold(true);
                            $campo = strpos($arrColumnas[$j], 'Pk') !== false ? 'ID' : $arrColumnas[$j];
                            $sheet->setCellValue($i . '1', strtoupper($campo));
                            $j++;
                        }
                        $j = 1;
                        foreach ($arGuias as $datos) {
                            $i = 'A';
                            $j++;
                            for ($col = 0; $col <= sizeof($arrColumnas) - 1; $col++) {
                                $dato = $datos[$arrColumnas[$col]];
                                if ($dato instanceof \DateTime) {
                                    $dato = $dato->format('Y-m-d');
                                }
                                $spreadsheet->getActiveSheet()->getStyle($i)->getFont()->setBold(false);
                                $sheet->setCellValue($i . $j, $dato);
                                $i++;
                            }
                        }
                        header('Content-Type: application/vnd.ms-excel');
                        header("Content-Disposition: attachment;filename=Guias.xls");
                        header('Cache-Control: max-age=0');

                        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
                        $writer->save('php://output');
                    } else {
                        Mensajes::error('El listado esta vacío, no hay nada que exportar');
                    }
                }
            }

        }

        return $this->render('informe/guia/general.html.twig', [
            'arGuias' => $arGuias,
            'form' => $form->createView()

        ]);
    }

}