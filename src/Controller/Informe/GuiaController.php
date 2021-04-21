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
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
                    $this->exportarExcel($arGuias);
                }
            }

        }

        return $this->render('informe/guia/general.html.twig', [
            'arGuias' => $arGuias,
            'form' => $form->createView()

        ]);
    }

    public function exportarExcel($arGuias)
    {
        ob_clean();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        if ($arGuias) {
            $libro = new Spreadsheet();
            $hoja = $libro->getActiveSheet();
            $hoja->setTitle('PagoDetalle');
            $j = 0;
            $arrColumnas = ['ID', 'NUMERO', 'DOCUMENTO', 'OI', 'OC', 'DES', 'ENT', 'CUM', 'NOV', 'FECHA', 'F_DES', 'F_ENT', 'F_CUM', 'DESTINATARIO', 'DESTINO',
                'PRODUCTO', 'FLETE', 'MANEJO', 'DECLARADO', 'UNIDADES'];
            for ($i = 'A'; $j <= sizeof($arrColumnas) - 1; $i++) {
                $hoja->getColumnDimension($i)->setAutoSize(true);
                $hoja->getStyle(1)->getFont()->setName('Arial')->setSize(8);
                $hoja->getStyle(1)->getFont()->setBold(true);
                $hoja->setCellValue($i . '1', strtoupper($arrColumnas[$j]));
                $j++;
            }
            $j = 2;
            foreach ($arGuias as $arGuia) {
                $fechaIngreso = date_create($arGuia['fechaIngreso']);
                $fechaDespacho = date_create($arGuia['fechaDespacho']);
                $fechaEntrega = date_create($arGuia['fechaEntrega']);
                $fechaCumplido = date_create($arGuia['fechaCumplido']);
                $hoja->getStyle($j)->getFont()->setName('Arial')->setSize(8);
                $hoja->getStyle("Q{$j}:T{$j}")->getNumberFormat()->setFormatCode('#,##0');
                $hoja->getStyle("J{$j}:M{$j}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
                $hoja->setCellValue('A' . $j, $arGuia['codigoGuiaPk']);
                $hoja->setCellValue('B' . $j, $arGuia['numero']);
                $hoja->setCellValue('C' . $j, $arGuia['documentoCliente']);
                $hoja->setCellValue('D' . $j, $arGuia['codigoOperacionIngresoFk']);
                $hoja->setCellValue('E' . $j, $arGuia['codigoOperacionCargoFk']);
                $hoja->setCellValue('F' . $j, $arGuia['estadoDespachado']?'SI':'NO');
                $hoja->setCellValue('G' . $j, $arGuia['estadoEntregado']?'SI':'NO');
                $hoja->setCellValue('H' . $j, $arGuia['estadoCumplido']?'SI':'NO');
                $hoja->setCellValue('I' . $j, $arGuia['estadoNovedad']?'SI':'NO');
                $hoja->setCellValue('J' . $j, Date::PHPToExcel($fechaIngreso->format("Y-m-d")));
                $hoja->setCellValue('K' . $j, $arGuia['estadoDespachado']?Date::PHPToExcel($fechaDespacho->format("Y-m-d")):'');
                $hoja->setCellValue('L' . $j, $arGuia['estadoEntregado']?Date::PHPToExcel($fechaEntrega->format("Y-m-d")):'');
                $hoja->setCellValue('M' . $j, $arGuia['estadoCumplido']?Date::PHPToExcel($fechaCumplido->format("Y-m-d")):'');
                $hoja->setCellValue('N' . $j, $arGuia['nombreDestinatario']);
                $hoja->setCellValue('O' . $j, $arGuia['ciudadDestino']);
                $hoja->setCellValue('P' . $j, $arGuia['productoNombre']);
                $hoja->setCellValue('Q' . $j, $arGuia['vrFlete']);
                $hoja->setCellValue('R' . $j, $arGuia['vrManejo']);
                $hoja->setCellValue('S' . $j, $arGuia['vrDeclara']);
                $hoja->setCellValue('T' . $j, $arGuia['unidades']);
                $j++;
            }

            $libro->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="guias.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $writer = new Xlsx($libro);
            $writer->save('php://output');
            exit;
        }
    }

}