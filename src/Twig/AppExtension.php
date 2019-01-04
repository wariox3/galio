<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Extension\AbstractExtension;

//Funciones personalizadas para twig
class AppExtension extends AbstractExtension
{

    public function getEnv($env)
    {
        return getenv($env);
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('obtenerNotificaciones', [$this, 'obtenerNotificaciones']),
        ];
    }

    /**
     * Esta función se encarga de imprimir las notificaciones para usuario (Mensajes).
     * @return string
     */
    public function obtenerNotificaciones()
    {
        $session = new Session();
        $flashes = $session->getFlashBag()->all();
        $html = [];
        foreach ($flashes as $type => $messages) {
            foreach ($messages AS $message) {
                $span = $this->createTag("span", "&times;", ['aria-hidden' => 'true']);
                $button = $this->createTag("button", $span, ['class' => 'close', 'data-dismiss' => 'alert', 'aria-label' => 'Close']);
                $alert = $this->createTag("div", $button . $message, ['class' => "alert alert-{$type}", 'data','style' => 'margin-top:5px;margin-bottom:2px;margin-left:5px;margin-right:5px;']);
                $html[] = $alert;
            }
        }
        $session->getFlashBag()->clear();
        return implode('', $html);
    }

    /**
     * Esta función nos permite obtener código html sin violar estandares de mezcla de código.
     * @param $tag
     * @param string $content
     * @param array $attrs
     * @return string
     */
    private function createTag($tag, $content = '', $attrs = [])
    {
        $attrs = implode(" ", array_map(function ($attr, $value) {
            return "{$attr}=\"{$value}\"";
        }, array_keys($attrs), $attrs));
        return "<{$tag}" . ($attrs ? " {$attrs}" : "") . ">{$content}</{$tag}>";
    }
}