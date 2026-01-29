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
    private $descripcion;
    private $urlHD;

    public function __construct($titulo, $url, $fecha, $descripcion, $urlHD) {
        $this->titulo = $titulo;
        $this->url = $url;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->urlHD = $urlHD;
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
    
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getUrlHD() {
        return $this->urlHD;
    }
}
?>