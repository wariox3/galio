<?php

namespace App\Formato;

use App\Entity\TteGuia;
use App\Entity\TteEmpresa;
use App\Entity\TteOperador;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;


class GuiaEnergy extends \FPDF
{

    public static $em;
    public static $codigoGuia;
    public static $imagen;
    public static $extension;


    public function Generar($em, $codigoGuia, $masivo = false)
    {
        ob_clean();
        //$em = $miThis->getDoctrine()->getManager();
        self::$em = $em;
        self::$codigoGuia = $codigoGuia;
        $arGuia = self::$em->getRepository(TteGuia::class)->find(self::$codigoGuia);
        $logo = self::$em->getRepository(TteOperador::class)->find(['codigoOperadorPk' => $arGuia->getCodigoOperadorFk()]);
        self::$imagen="data:image/'{$logo->getExtension()}';base64," . base64_encode(stream_get_contents($logo->getImagen()));
        self::$extension=$logo->getExtension();
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
        for ($i = 0; $i <= 2; $i++) {
            try {
                if (self::$imagen) {
                    $pdf->Image(self::$imagen, 20, $y - 15, 30, 15, self::$extension);
                }

            } catch (\Exception $exception) {
            }
            $pdf->Image('../public/recursos/logo-supertransporte.png', 10, $y -5 , 40, 15);
            $codigoBarras->setText($arGuia->getNumero());
            $codigoBarras->setType(BarcodeGenerator::Code39);
            $codigoBarras->setScale(2);
            $codigoBarras->setThickness(25);
            $codigoBarras->setFontSize(0);
            $codigo = $codigoBarras->generate();
            $pdf->Image('data:image/png;base64,' . $codigo, 165, $y - 10, 33, 10, 'png');
//
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(168, $y - 15);
            $pdf->Cell(30, 4, $arGuia->getNumero(), 0, 0, 'R');
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Text(94, $y - 10, utf8_decode($arEmpresa->getNombre()));
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Text(92, $y - 5, utf8_decode('NIT'. ' ' . $arEmpresa->getNit()));
            $pdf->Text(75, $y - 2, utf8_decode($arEmpresa->getDireccion()));
            $pdf->Text(92, $y + 1,  utf8_decode($arEmpresa->getTelefono()));
            $pdf->SetXY(10, $y +10);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 6.5);
            $pdf->Cell(65, 4, utf8_decode("REMITENTE IDENTIFICACION NOMBRE DIRECCION"), 'LT', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode("POBLACION ORIGEN CODIGO"), 'LT', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode("POBLACION DESTINO CODIGO"), 'LT', 0, 'L', 1);
            $pdf->Cell(25, 4, utf8_decode("DOC REFERENCIA"), 'LT', 0, 'L', 1);
            $pdf->Cell(20, 4, utf8_decode("FORMA PAGO"), 'LTR', 0, 'L', 1);
            $pdf->SetXY(10, $y +14);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(65, 4, utf8_decode($arEmpresa->getNombre() . ' '. $arEmpresa->getNit()), 'L', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode($arGuia->getCodigoCiudadOrigenFk()), 'L', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode($arGuia->getCodigoCiudadDestinoFk()), 'L', 0, 'L', 1);
            $pdf->Cell(25, 4, utf8_decode(""), 'L', 0, 'L', 1);
            $pdf->Cell(20, 4, utf8_decode(""), 'LR', 0, 'L', 1);
            $pdf->SetXY(10, $y +18);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(65, 4, utf8_decode($arEmpresa->getDireccion() . ' ' .$arEmpresa->getTelefono()), 'BL', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode($arGuia->getCiudadOrigenRel()->getNombre()), 'BL', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode($arGuia->getCiudadDestinoRel()->getNombre()), 'BL', 0, 'L', 1);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(25, 4, utf8_decode("REL DESPACHO"), 'LTB', 0, 'L', 1);
            $pdf->Cell(20, 4, utf8_decode(""), 'LBR', 0, 'BL', 1);
            $pdf->SetXY(10, $y +22);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', 'B', 6.5);
            $pdf->Cell(65, 4, utf8_decode("DESTINATARIO NOMBRE DIRECCION TELEFONO"), 'LT', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode("FECHA ELABORACION"), 'LT', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode("FECHA ENTREGA"), 'LT', 0, 'L', 1);
            $pdf->Cell(25, 4, utf8_decode("NUM RELACION"), 'LT', 0, 'L', 1);
            $pdf->Cell(20, 4, utf8_decode("ZONA"), 'LTR', 0, 'L', 1);
            $pdf->SetXY(10, $y +26);
            $pdf->SetFillColor(272, 272, 272);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(65, 4, utf8_decode($arGuia->getDestinatarioNombre()), 'L', 0, 'L', 1);
                $pdf->Cell(40, 4, utf8_decode($arGuia->getFecha()->format('d') . ' ' . $arGuia->getFecha()->format('m') . ' '. $arGuia->getFecha()->format('Y')), 'L', 0, 'L', 1);
            $pdf->Cell(40, 4, utf8_decode(""), 'L', 0, 'L', 1);
            $pdf->Cell(25, 4, utf8_decode(""), 'L', 0, 'L', 1);
            $pdf->Cell(20, 4, utf8_decode(""), 'LR', 0, 'L', 1);


//
//            $pdf->SetXY(71, $y +20);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(47, 6, utf8_decode("Origen:"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(84, $y +20);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(47, 6, utf8_decode($arGuia->getCiudadOrigenRel()->getNombre()), 'TRB', 0, 'L', 1);
//
//            $pdf->SetXY(131, $y+20);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(47, 6, utf8_decode("Destino:"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(151, $y+20);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(47, 6, utf8_decode($arGuia->getCiudadDestinoRel()->getNombre()), 'TRB', 0, 'L', 1);
//
//            $pdf->SetXY(10, $y + 6);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(49, 6, utf8_decode("Remite:"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(22, $y + 6);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(49, 6, utf8_decode($arGuia->getRemitente()), 'TRB', 0, 'L', 1);
//
//            $pdf->SetXY(71, $y + 6);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(77, 6, utf8_decode("Direccion:"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(87, $y + 6);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(77, 6, utf8_decode($arEmpresa->getDireccion()), 'TRB', 0, 'L', 1);
//
//            $pdf->SetXY(161, $y + 6);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(23, 6, utf8_decode("Tel:"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(175, $y + 6);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(23, 6, utf8_decode($arEmpresa->getTelefono()), 'TRB', 0, 'L', 1);
//
//            $pdf->SetXY(10, $y + 12);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(49, 6, utf8_decode("Destinatario:"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(28, $y + 12);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(49, 6, utf8_decode($arGuia->getDestinatarioNombre()), 'TRB', 0, 'L', 1);
//
//            $pdf->SetXY(71, $y + 12);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(77, 6, utf8_decode("Direccion:"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(87, $y + 12);
//            $pdf->SetFont('Arial', '', 7);
//            $pdf->Cell(77, 6, utf8_decode(substr($arGuia->getDestinatarioDireccion(), 0, 60)), 'TRB', 0, 'L', 1);
//
//            $pdf->SetXY(161, $y + 12);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(23, 6, utf8_decode("Tel:"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(175, $y + 12);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(23, 6, utf8_decode($arGuia->getDestinatarioTelefono()), 'TRB', 0, 'L', 1);
//
//            $pdf->SetXY(10, $y + 18);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(43, 6, utf8_decode("Tipo cobro:"), 'TL', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(28, $y + 18);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(43, 6, utf8_decode($arGuia->getGuiaTipoRel()->getNombre()), 'TR', 0, 'L', 1);
//            // segunda fila del bloque
//            $pdf->SetXY(10, $y + 24);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(43, 6, utf8_decode("Documento:"), 'LB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(28, $y + 24);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(43, 6, utf8_decode($arGuia->getClienteDocumento()), 'RB', 0, 'L', 1);
//
//            $pdf->SetXY(71.5, $y + 19);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 7.8);
//            $pdf->Multicell(128, 3.5, utf8_decode("Observaciones:" . $arGuia->getComentario()), 0, 'L');
//            $pdf->SetXY(71, $y + 18);
//            $pdf->Cell(127, 12, '', 1, 2, 'C');
//
//            $pdf->SetXY(10, $y + 30);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(20, 6, utf8_decode("Cant"), 'TLB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(20, $y + 30);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(20, 6, utf8_decode("Peso"), 'TB', 0, 'L', 1);
//            $pdf->SetXY(32, $y + 30);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(20, 6, utf8_decode("Vol"), 'TB', 0, 'L', 1);
//            $pdf->SetXY(45, $y + 30);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(20, 6, utf8_decode("Flete"), 'TB', 0, 'L', 1);
//            $pdf->SetXY(60, $y + 30);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(20, 6, utf8_decode("Manejo"), 'TB', 0, 'L', 1);
//            $pdf->SetXY(80, $y + 30);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(20, 6, utf8_decode("Cobro"), 'TB', 0, 'L', 1);
//            $pdf->SetXY(95, $y + 30);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(40, 6, utf8_decode("Declarado"), 'TB', 0, 'L', 1);
//            $pdf->SetXY(130, $y + 30);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(68, 6, utf8_decode("DEVOLVER FIRMADO Y SELLADO"), 'TBR', 0, 'L', 1);
//
//            $pdf->SetXY(10, $y + 36);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, number_format($arGuia->getUnidades()), 'TL', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(20, $y + 36);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, number_format($arGuia->getPesoReal()), 'T', 0, 'L', 1);
//            $pdf->SetXY(32, $y + 36);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, number_format($arGuia->getPesoVolumen()), 'T', 0, 'L', 1);
//            $pdf->SetXY(45, $y + 36);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, number_format($arGuia->getVrFlete()), 'T', 0, 'L', 1);
//            $pdf->SetXY(60, $y + 36);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, number_format($arGuia->getVrManejo()), 'T', 0, 'L', 1);
//            $pdf->SetXY(80, $y + 36);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, number_format($arGuia->getVrCobroEntrega()), 'T', 0, 'L', 1);
//            $pdf->SetXY(95, $y + 36);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(40, 6, number_format($arGuia->getVrDeclara()), 'T', 0, 'L', 1);
//            $pdf->SetXY(115, $y + 36);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(83, 6, utf8_decode("NOMBRE"), 'TLR', 0, 'L', 1);
//
//            $pdf->SetXY(10, $y + 42);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, '', 'LB', 0, 'L', 1);
//            $pdf->SetFillColor(272, 272, 272);
//            $pdf->SetXY(25, $y + 42);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, '', 'B', 0, 'L', 1);
//            $pdf->SetXY(45, $y + 42);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, '', 'B', 0, 'L', 1);
//            $pdf->SetXY(60, $y + 42);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, '', 'B', 0, 'L', 1);
//            $pdf->SetXY(80, $y + 42);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(20, 6, '', 'B', 0, 'L', 1);
//            $pdf->SetXY(95, $y + 42);
//            $pdf->SetFont('Arial', '', 8);
//            $pdf->Cell(40, 6, '', 'B', 0, 'L', 1);
//            $pdf->SetXY(115, $y + 42);
//            $pdf->SetFont('Arial', 'B', 8);
//            $pdf->Cell(83, 6, utf8_decode("CC NIT.                                                       FECHA HORA"), 'LBR', 0, 'L', 1);

            $y += 68;
        }
    }

}

?>