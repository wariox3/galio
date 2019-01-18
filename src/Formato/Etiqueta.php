<?php

namespace App\Formato;


use App\Entity\TteDespacho;
use App\Entity\TteGuia;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Doctrine\ORM\EntityManager;

class Etiqueta extends \FPDF
{
    public static $em;
    public static $codigoGuia;
    public static $codigoDespacho;

    /**
     * @param $em
     * @param string $codigoGuia
     * @param string $codigoDespacho
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function Generar($em, $codigoGuia = "", $codigoDespacho = "")
    {
        ob_clean();
        //$em = $miThis->getDoctrine()->getManager();
        self::$em = $em;
        self::$codigoDespacho = $codigoDespacho;
        self::$codigoGuia = $codigoGuia;
        $pdf = new Etiqueta('L', 'mm', array(50, 75));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $nombre = $codigoDespacho != '' ? 'EtiquetasDespacho' . $codigoDespacho . '.pdf' : 'EtiquetasGuia' . $codigoGuia . '.pdf';
        $pdf->Output($nombre, 'I');
    }

    public function Header()
    {
    }

    /**
     * @param $pdf \FPDF
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function Body($pdf)
    {
        /** @var  $em EntityManager */
        $em = self::$em;
        if (self::$codigoDespacho != '') {
            $arDespacho = $em->find(TteDespacho::class, self::$codigoDespacho);
            $contador = 0;
            $arGuias = $em->getRepository(TteGuia::class)->findBy(['codigoDespachoFk' => self::$codigoDespacho]);
            /** @var  $arGuia TteGuia */
            foreach ($arGuias as $arGuia) {
                $contador++;
                $this->generarBody($pdf, $arGuia);
                if ($contador < $arDespacho->getGuias()) {
                    $pdf->AddPage();
                }
            }
        } else {
            $arGuia = $em->find(TteGuia::class, self::$codigoGuia);
            $this->generarBody($pdf, $arGuia);
        }
    }

    public function Footer()
    {
    }

    /**
     * @param $pdf \FPDF
     * @param $arGuia TteGuia
     */
    public function generarBody($pdf, $arGuia)
    {
        $codigoBarras = new BarcodeGenerator();
        $codigoBarras->setText($arGuia->getNumero());
        $codigoBarras->setType(BarcodeGenerator::Code39);
        $codigoBarras->setScale(2);
        $codigoBarras->setThickness(25);
        $codigoBarras->setFontSize(0);
        $codigoBarras = $codigoBarras->generate();
        for ($i = 1; $i <= $arGuia->getUnidades(); $i++) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Text(5, 5, "COTRASCAL S.A.S   " . $arGuia->getNumero());
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Text(5, 10, 'REMITE:' . $arGuia->getEmpresaRel()->getNombre());
            $pdf->Text(15, 14, "INFORMACION DESTINATARIO");
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Text(58, 14, $i . '/' . $arGuia->getUnidades());
            $pdf->SetFont('Arial', '', 7);
            $pdf->Text(5, 18, "NIT:" . $arGuia->getEmpresaRel()->getNit());
            $pdf->Text(40, 18, "DOC:" . $arGuia->getClienteDocumento());
            $pdf->Text(5, 21, "NOMBRE:" . utf8_decode($arGuia->getDestinatarioNombre()));
            $pdf->Text(5, 24, "DIR:" . $arGuia->getDestinatarioDireccion());
            $pdf->Text(5, 27, "TEL:" . $arGuia->getDestinatarioRel()->getTelefono());
            $pdf->Text(5, 30, "DESTINO:" . $arGuia->getCiudadDestinoRel()->getNombre());
            $pdf->Text(5, 33, "U.EMP:" . $arGuia->getProductoReferencia());
//            $pdf->Text(5, 36, "DESP:" . $arGuia->getDespachador() . " ZONA:" . $arGuia->getZona());
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Image('data:image/png;base64,' . $codigoBarras, 15, 38, 50, 10, 'png');
            if ($i < $arGuia->getUnidades()) {
                $pdf->AddPage();
            }
        }
    }
}