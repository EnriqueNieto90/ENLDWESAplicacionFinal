<?php
/**
 * Clase entidad Departamento.
 * * Representa la estructura de un Departamento en el sistema.
 * Sirve como objeto de transferencia de datos (DTO) entre la base de datos y la aplicación.
 * * @author Enrique Nieto Lorenzo
 * @since 23/01/2026
 * @version 1.0.0
 */
class Departamento {
    
    //ATRIBUTOS
    
    /** @var string Código alfabético único identificador del departamento (Máximo 3 caracteres). */
    private $codDepartamento;
    
    /** @var string Descripción o nombre completo del departamento. */
    private $descDepartamento;
    
    /** @var string Fecha y hora en la que se creó el departamento. */
    private $fechaCreacionDepartamento;
    
    /** @var float Cifra económica que representa el volumen de negocio del departamento. */
    private $volumenDeNegocio;
    
    /** @var string|null Fecha y hora en la que se dio de baja el departamento. Null si está activo. */
    private $fechaBajaDepartamento;
    
    //CONSTRUCTOR
    
    /**
     * Constructor de la clase Departamento.
     * * Inicializa una nueva instancia de la entidad con los datos proporcionados.
     *
     * @param string      $codDepartamento           Código único del departamento.
     * @param string      $descDepartamento          Descripción del departamento.
     * @param string      $fechaCreacionDepartamento Fecha de creación.
     * @param float       $volumenDeNegocio          Volumen de negocio inicial.
     * @param string|null $fechaBajaDepartamento     Fecha de baja (por defecto null si es un alta nueva).
     */
    public function __construct($codDepartamento, $descDepartamento, $fechaCreacionDepartamento, $volumenDeNegocio, $fechaBajaDepartamento = null) {
        $this->codDepartamento           = $codDepartamento;
        $this->descDepartamento          = $descDepartamento;
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
        $this->volumenDeNegocio          = $volumenDeNegocio;
        $this->fechaBajaDepartamento     = $fechaBajaDepartamento;
    }

    // GETTERS
    
    /**
     * Obtiene el código del departamento.
     *
     * @return string
     */
    public function getCodDepartamento() {
        return $this->codDepartamento;
    }

    /**
     * Obtiene la descripción del departamento.
     *
     * @return string
     */
    public function getDescDepartamento() {
        return $this->descDepartamento;
    }

    /**
     * Obtiene la fecha de creación del departamento.
     *
     * @return string
     */
    public function getFechaCreacionDepartamento() {
        return $this->fechaCreacionDepartamento;
    }

    /**
     * Obtiene el volumen de negocio del departamento.
     *
     * @return float
     */
    public function getVolumenDeNegocio() {
        return $this->volumenDeNegocio;
    }

    /**
     * Obtiene la fecha de baja del departamento.
     *
     * @return string|null
     */
    public function getFechaBajaDepartamento() {
        return $this->fechaBajaDepartamento;
    }

    
    // SETTERS
    
    /**
     * Modifica la descripción del departamento.
     *
     * @param string $descDepartamento Nueva descripción del departamento.
     * @return void
     */
    public function setDescDepartamento($descDepartamento): void {
        $this->descDepartamento = $descDepartamento;
    }

    /**
     * Modifica la fecha de creación del departamento.
     *
     * @param string $fechaCreacionDepartamento Nueva fecha de creación.
     * @return void
     */
    public function setFechaCreacionDepartamento($fechaCreacionDepartamento): void {
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
    }

    /**
     * Modifica el volumen de negocio del departamento.
     *
     * @param float $volumenDeNegocio Nuevo volumen de negocio.
     * @return void
     */
    public function setVolumenDeNegocio($volumenDeNegocio): void {
        $this->volumenDeNegocio = $volumenDeNegocio;
    }

    /**
     * Modifica la fecha de baja del departamento.
     *
     * @param string|null $fechaBajaDepartamento Nueva fecha de baja o null para reactivar.
     * @return void
     */
    public function setFechaBajaDepartamento($fechaBajaDepartamento): void {
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

}
?>
