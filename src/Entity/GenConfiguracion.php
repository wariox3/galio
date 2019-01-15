<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenConfiguracionRepository")
 */
class GenConfiguracion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_configuracion_pk", type="string", length=2)
     */
    private $codigoConfiguracionPk = 1;

    /**
     * @ORM\Column(name="url_cesio", type="string", length=100, nullable=true)
     */
    private $urlCesio;

    /**
     * @ORM\Column(name="url_oro", type="string", length=100, nullable=true)
     */
    private $urlOro;

    /**
     * @return mixed
     */
    public function getCodigoConfiguracionPk()
    {
        return $this->codigoConfiguracionPk;
    }

    /**
     * @param mixed $codigoConfiguracionPk
     */
    public function setCodigoConfiguracionPk($codigoConfiguracionPk): void
    {
        $this->codigoConfiguracionPk = $codigoConfiguracionPk;
    }

    /**
     * @return mixed
     */
    public function getUrlCesio()
    {
        return $this->urlCesio;
    }

    /**
     * @param mixed $urlCesio
     */
    public function setUrlCesio($urlCesio): void
    {
        $this->urlCesio = $urlCesio;
    }

    /**
     * @return mixed
     */
    public function getUrlOro()
    {
        return $this->urlOro;
    }

    /**
     * @param mixed $urlOro
     */
    public function setUrlOro($urlOro): void
    {
        $this->urlOro = $urlOro;
    }
}

