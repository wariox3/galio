<?php

namespace App\Formato;

use App\Entity\TteGuia;
use App\Entity\TteEmpresa;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;


class Guia extends \FPDF
{

    public static $em;
    public static $codigoGuia;
    public static $imagen;
    public static $extension;
    public static $masivo;


    public function Generar($em, $codigoGuia, $masivo = false)
    {
        ob_clean();
        //$em = $miThis->getDoctrine()->getManager();
        self::$em = $em;
        self::$codigoGuia = $codigoGuia;
        self::$masivo = $masivo;
        $pdf = new Guia();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Guia.pdf", 'D');
    }

    public function Header()
    {
//        $this->SetFillColor(200, 200, 200);
//        $this->SetFont('Arial', 'B', 10);
        $this->Ln(16);
//        $this->EncabezadoDetalles();

    }

    public function EncabezadoDetalles()
    {
    }

    public function Body($pdf)
    {
        $codigoBarras = new BarcodeGenerator();
        $y = 20;
        $cont = 0;
        /** @var  $arGuia TteGuia */
        $arGuia = self::$em->getRepository(TteGuia::class)->find(self::$codigoGuia);
        /** @var  $arEmpresa TteEmpresa */
        $arEmpresa = $arGuia->getEmpresaRel();
        for ($i = 0; $i <= 3; $i++) {
            try {
                $pdf->Image('img/logo.png', 10, $y - 16, 40, 15);
            } catch (\Exception $exception) {
            }
            $codigoBarras->setText($arGuia->getNumero());
            $codigoBarras->setType(BarcodeGenerator::Code39);
            $codigoBarras->setScale(2);
            $codigoBarras->setThickness(25);
            $codigoBarras->setFontSize(0);
            $codigo = $codigoBarras->generate();
            $pdf->Image('data:image/png;base64,' . $codigo, 165, $y - 10, 33, 10, 'png');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(168, $y - 15);
            $pdf->Cell(30, 4, $arGuia->getNumero(), 0, 0, 'R');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Text(55, $y - 13, utf8_decode($arEmpresa->getNombre()));
            $pdf->Text(55, $y - 9, utf8_decode($arEmpresa->getNit()));
            $pdf->Text(55, $y - 5, utf8_decode($arEmpresa->getDireccion()));
            $pdf->Text(55, $y - 1, utf8_decode($arEmpresa->getTelefono()));
            $pdf->SetXY(10, $y);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(49, 6, utf8_decode("Fecha:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(22, $y);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(49, 6, $arGuia->getFechaIngreso()->format('Y-m-d'), 'TRB', 0, 'L', 1);

            $pdf->SetXY(71, $y);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(47, 6, utf8_decode("Origen:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(84, $y);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(47, 6, utf8_decode($arGuia->getCiudadOrigenRel()->getNombre()), 'TRB', 0, 'L', 1);

            $pdf->SetXY(131, $y);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(47, 6, utf8_decode("Destino:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(151, $y);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(47, 6, utf8_decode($arGuia->getCiudadDestinoRel()->getNombre()), 'TRB', 0, 'L', 1);

            $pdf->SetXY(10, $y + 6);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(49, 6, utf8_decode("Remite:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(22, $y + 6);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(49, 6, utf8_decode($arGuia->getRemitente()), 'TRB', 0, 'L', 1);

            $pdf->SetXY(71, $y + 6);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(77, 6, utf8_decode("Direccion:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(87, $y + 6);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(77, 6, utf8_decode($arEmpresa->getDireccion()), 'TRB', 0, 'L', 1);

            $pdf->SetXY(161, $y + 6);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(23, 6, utf8_decode("Tel:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(175, $y + 6);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(23, 6, utf8_decode($arEmpresa->getTelefono()), 'TRB', 0, 'L', 1);

            $pdf->SetXY(10, $y + 12);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(49, 6, utf8_decode("Destinatario:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(28, $y + 12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(49, 6, utf8_decode($arGuia->getDestinatarioNombre()), 'TRB', 0, 'L', 1);

            $pdf->SetXY(71, $y + 12);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(77, 6, utf8_decode("Direccion:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(87, $y + 12);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(77, 6, utf8_decode(substr($arGuia->getDestinatarioDireccion(), 0, 60)), 'TRB', 0, 'L', 1);

            $pdf->SetXY(161, $y + 12);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(23, 6, utf8_decode("Tel:"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(175, $y + 12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(23, 6, utf8_decode($arGuia->getDestinatarioTelefono()), 'TRB', 0, 'L', 1);

            $pdf->SetXY(10, $y + 18);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(43, 6, utf8_decode("Tipo cobro:"), 'TL', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(28, $y + 18);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(43, 6, utf8_decode($arGuia->getGuiaTipoRel()->getNombre()), 'TR', 0, 'L', 1);
            // segunda fila del bloque
            $pdf->SetXY(10, $y + 24);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(43, 6, utf8_decode("Documento:"), 'LB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(28, $y + 24);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(43, 6, utf8_decode($arGuia->getClienteDocumento()), 'RB', 0, 'L', 1);

            $pdf->SetXY(71.5, $y + 19);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 7.8);
            $pdf->Multicell(128, 3.5, utf8_decode("Observaciones:" . $arGuia->getComentario()), 0, 'L');
            $pdf->SetXY(71, $y + 18);
            $pdf->Cell(127, 12, '', 1, 2, 'C');

            $pdf->SetXY(10, $y + 30);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 6, utf8_decode("Cant"), 'TLB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(20, $y + 30);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 6, utf8_decode("Peso"), 'TB', 0, 'L', 1);
            $pdf->SetXY(32, $y + 30);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 6, utf8_decode("Vol"), 'TB', 0, 'L', 1);
            $pdf->SetXY(45, $y + 30);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 6, utf8_decode("Flete"), 'TB', 0, 'L', 1);
            $pdf->SetXY(60, $y + 30);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 6, utf8_decode("Manejo"), 'TB', 0, 'L', 1);
            $pdf->SetXY(80, $y + 30);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 6, utf8_decode("Cobro"), 'TB', 0, 'L', 1);
            $pdf->SetXY(95, $y + 30);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(40, 6, utf8_decode("Declarado"), 'TB', 0, 'L', 1);
            $pdf->SetXY(130, $y + 30);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(68, 6, utf8_decode("DEVOLVER FIRMADO Y SELLADO"), 'TBR', 0, 'L', 1);

            $pdf->SetXY(10, $y + 36);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, number_format($arGuia->getUnidades()), 'TL', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(20, $y + 36);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, number_format($arGuia->getPesoReal()), 'T', 0, 'L', 1);
            $pdf->SetXY(32, $y + 36);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, number_format($arGuia->getPesoVolumen()), 'T', 0, 'L', 1);
            $pdf->SetXY(45, $y + 36);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, number_format($arGuia->getVrFlete()), 'T', 0, 'L', 1);
            $pdf->SetXY(60, $y + 36);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, number_format($arGuia->getVrManejo()), 'T', 0, 'L', 1);
            $pdf->SetXY(80, $y + 36);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, number_format($arGuia->getVrCobroEntrega()), 'T', 0, 'L', 1);
            $pdf->SetXY(95, $y + 36);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(40, 6, number_format($arGuia->getVrDeclara()), 'T', 0, 'L', 1);
            $pdf->SetXY(115, $y + 36);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(83, 6, utf8_decode("NOMBRE"), 'TLR', 0, 'L', 1);

            $pdf->SetXY(10, $y + 42);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, '', 'LB', 0, 'L', 1);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetXY(25, $y + 42);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, '', 'B', 0, 'L', 1);
            $pdf->SetXY(45, $y + 42);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, '', 'B', 0, 'L', 1);
            $pdf->SetXY(60, $y + 42);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, '', 'B', 0, 'L', 1);
            $pdf->SetXY(80, $y + 42);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 6, '', 'B', 0, 'L', 1);
            $pdf->SetXY(95, $y + 42);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(40, 6, '', 'B', 0, 'L', 1);
            $pdf->SetXY(115, $y + 42);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(83, 6, utf8_decode("CC NIT.                                                       FECHA HORA"), 'LBR', 0, 'L', 1);

            $y += 68;
        }
    }

}

?>