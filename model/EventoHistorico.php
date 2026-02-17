<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 17/02/2026
 * @description: Clase entidad EventoHistorico para la API de Wikipedia.
 */
class EventoHistorico {
    private $anio;
    private $descripcion;
    private $urlArticulo;

    public function __construct($anio, $descripcion, $urlArticulo) {
        $this->anio = $anio;
        $this->descripcion = $descripcion;
        $this->urlArticulo = $urlArticulo;
    }

    public function getAnio() {
        return $this->anio;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getUrlArticulo() {
        return $this->urlArticulo;
    }
}
?>

