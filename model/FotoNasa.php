<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 21/01/2026
 * @description: Clase FotoNasa
 */

class FotoNasa {
    private $titulo;
    private $url;
    private $fecha;

    public function __construct($titulo, $url, $fecha) {
        $this->titulo = $titulo;
        $this->url = $url;
        $this->fecha = $fecha;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getFecha() {
        return $this->fecha;
    }
}
?>