<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 23/01/2026
 * @description Clase entidad que representa un departamento del sistema.
 */

class Departamento {
    
    //ATRIBUTOS
    private $codDepartamento;
    private $descDepartamento;
    private $fechaCreacionDepartamento;
    private $volumenDeNegocio;
    private $fechaBajaDepartamento;
    
    //CONSTRUCTOR
    public function __construct($codDepartamento, $descDepartamento, $fechaCreacionDepartamento, $volumenDeNegocio, $fechaBajaDepartamento=null) {
        $this->codDepartamento = $codDepartamento;
        $this->descDepartamento = $descDepartamento;
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
        $this->volumenDeNegocio = $volumenDeNegocio;
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

        // GETTERS
    public function getCodDepartamento() {
        return $this->codDepartamento;
    }

    public function getDescDepartamento() {
        return $this->descDepartamento;
    }

    public function getFechaCreacionDepartamento() {
        return $this->fechaCreacionDepartamento;
    }

    public function getVolumenDeNegocio() {
        return $this->volumenDeNegocio;
    }

    public function getFechaBajaDepartamento() {
        return $this->fechaBajaDepartamento;
    }

    
    
    // SETTERS
    public function setDescDepartamento($descDepartamento): void {
        $this->descDepartamento = $descDepartamento;
    }

    public function setFechaCreacionDepartamento($fechaCreacionDepartamento): void {
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
    }

    public function setVolumenDeNegocio($volumenDeNegocio): void {
        $this->volumenDeNegocio = $volumenDeNegocio;
    }

    public function setFechaBajaDepartamento($fechaBajaDepartamento): void {
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

}
?>
