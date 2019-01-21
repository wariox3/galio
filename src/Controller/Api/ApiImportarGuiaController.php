<?php

namespace App\Controller\Api;

use App\Entity\TteGuia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiImportarGuiaController extends Controller
{
    /**
     * @param Request $request
     * @param int $codigoOperador
     * @Rest\Post("/api/pendientes/guia/{codigoOperador}", name="api_pendientes_guia")
     * @return mixed
     */
    public function pendientes(Request $request, $codigoOperador = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $arrDatos = json_decode($request->getContent(), true);
        $arGuias = $em->getRepository(TteGuia::class)->pendiente($codigoOperador, $arrDatos);
        $respuesta = [];
        if ($arGuias) {
            $respuesta = $arGuias;
        }
        return new JsonResponse($respuesta);
    }

    /**
     * @param Request $request
     * @Rest\Post("/api/importar/guia", name="api_importar_guia")
     * @return bool
     */
    public function importar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arrDatos = json_decode($request->getContent(), true);
        $respuesta = $em->getRepository(TteGuia::class)->exportarGuia($arrDatos);
        return $respuesta;
    }
}

