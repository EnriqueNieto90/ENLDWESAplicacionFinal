<?php
/**
 * Clase que representa un error o excepción capturada en la aplicación.
 * * Se utiliza para encapsular la información técnica de los errores (código, 
 * descripción, archivo y línea) y transportarla de manera segura hacia la vista 
 * de errores (vError.php) a través de la sesión, evitando mostrar datos sensibles 
 * directamente en pantalla.
 *
 * @author Enrique Nieto Lorenzo
 * @since 19/01/2026
 * @version 1.0.0
 */
class ErrorApp {
    
    /** @var int|string Código identificador del error (Ej: Códigos de error PDO o HTTP). */
    private $codError;
    
    /** @var string Mensaje descriptivo o técnico detallando el motivo del error. */
    private $descError;
    
    /** @var string Ruta absoluta o relativa del archivo PHP donde se originó la excepción. */
    private $archivoError;    
    
    /** @var int Número de la línea de código exacta donde se lanzó el error. */
    private $lineaError;

    /**
     * Constructor de la clase ErrorApp.
     * * Inicializa un nuevo objeto de error con toda la información técnica necesaria 
     * para su posterior visualización o registro en logs.
     *
     * @param int|string $codError     Código del error.
     * @param string     $descError    Mensaje o descripción del error.
     * @param string     $archivoError Archivo donde ocurrió el error.
     * @param int        $lineaError   Línea de código del error.
     */
    public function __construct($codError, $descError, $archivoError, $lineaError) {
        $this->codError     = $codError;
        $this->descError    = $descError;
        $this->archivoError = $archivoError;
        $this->lineaError   = $lineaError;
    }

    /**
     * Obtiene el código del error.
     *
     * @return int|string
     */
    public function getCodError() { 
        return $this->codError; 
    }
    
    /**
     * Obtiene la descripción o mensaje del error.
     *
     * @return string
     */
    public function getDescError() { 
        return $this->descError; 
    }
    
    /**
     * Obtiene la ruta del archivo donde se produjo el error.
     *
     * @return string
     */
    public function getArchivoError() { 
        return $this->archivoError;
    }
    
    /**
     * Obtiene el número de línea donde saltó la excepción.
     *
     * @return int
     */
    public function getLineaError() { 
        return $this->lineaError; 
    }
}
?>