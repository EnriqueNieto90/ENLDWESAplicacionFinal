<?php

/**
 * Clase entidad FotoNasa.
 * * Representa la información de la Fotografía Astronómica del Día (APOD) extraída 
 * a través de la API REST de la NASA. Sirve como objeto de transferencia de datos (DTO)
 * para encapsular la respuesta y enviarla a la vista.
 *
 * @author Enrique Nieto Lorenzo
 * @since 21/01/2026
 * @version 1.0.0
 */
class FotoNasa {

    /** @var string Título oficial de la fotografía o recurso astronómico. */
    private $titulo;
    
    /** @var string URL de la imagen en resolución estándar o formato Base64. */
    private $url;
    
    /** @var string Fecha de publicación de la fotografía (Formato: YYYY-MM-DD). */
    private $fecha;
    
    /** @var string Explicación detallada o contexto científico proporcionado por la NASA. */
    private $descripcion;
    
    /** @var string URL de la imagen en alta resolución (High Definition). */
    private $urlHD;

    /**
     * Constructor de la clase FotoNasa.
     * * Inicializa una nueva instancia encapsulando los datos decodificados 
     * provenientes de la respuesta JSON de la API.
     *
     * @param string $titulo      Título de la fotografía.
     * @param string $url         Enlace o cadena codificada (Base64) de la imagen.
     * @param string $fecha       Fecha correspondiente a la publicación de la imagen.
     * @param string $descripcion Texto explicativo y detallado del suceso o imagen.
     * @param string $urlHD       Enlace directo a la versión de alta calidad de la imagen.
     */
    public function __construct($titulo, $url, $fecha, $descripcion, $urlHD) {
        $this->titulo      = $titulo;
        $this->url         = $url;
        $this->fecha       = $fecha;
        $this->descripcion = $descripcion;
        $this->urlHD       = $urlHD;
    }

    /**
     * Obtiene el título oficial de la fotografía.
     *
     * @return string
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Obtiene la URL de resolución estándar de la imagen.
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Obtiene la fecha de publicación de la imagen.
     *
     * @return string
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Obtiene la descripción o explicación científica del contenido.
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Obtiene la URL de la imagen en alta resolución.
     *
     * @return string
     */
    public function getUrlHD() {
        return $this->urlHD;
    }
}

?>