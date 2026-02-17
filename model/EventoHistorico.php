<?php
/**
 * Clase entidad EventoHistorico.
 * * Representa la estructura de un suceso histórico extraído a través de la API de Wikipedia.
 * Sirve como objeto de transferencia de datos (DTO) para encapsular la información 
 * de la efeméride antes de ser enviada a la vista (vRest.php).
 *
 * @author Enrique Nieto Lorenzo
 * @since 17/02/2026
 * @version 1.0.0
 */
class EventoHistorico {
    
    /** @var string|int Año en el que ocurrió el evento histórico. */
    private $anio;
    
    /** @var string Descripción o resumen del suceso histórico. */
    private $descripcion;
    
    /** @var string URL directa al artículo de Wikipedia para obtener más detalles. */
    private $urlArticulo;

    /**
     * Constructor de la clase EventoHistorico.
     * * Inicializa una nueva instancia con los datos extraídos y decodificados 
     * desde el JSON proporcionado por la API REST de Wikipedia.
     *
     * @param string|int $anio        Año del suceso.
     * @param string     $descripcion Texto explicativo del evento.
     * @param string     $urlArticulo Enlace web al artículo relacionado.
     */
    public function __construct($anio, $descripcion, $urlArticulo) {
        $this->anio        = $anio;
        $this->descripcion = $descripcion;
        $this->urlArticulo = $urlArticulo;
    }

    /**
     * Obtiene el año en el que sucedió el evento.
     *
     * @return string|int
     */
    public function getAnio() {
        return $this->anio;
    }

    /**
     * Obtiene la descripción detallada del evento histórico.
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Obtiene la URL hacia el artículo de Wikipedia asociado al evento.
     *
     * @return string
     */
    public function getUrlArticulo() {
        return $this->urlArticulo;
    }
}
?>

