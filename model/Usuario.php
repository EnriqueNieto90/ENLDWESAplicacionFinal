<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 11/01/2026
 * @description Clase entidad que representa un usuario del sistema.
 */

class Usuario {
    
    //ATRIBUTOS
    private $codUsuario;
    private $password;
    private $descUsuario;
    private $numConexiones;
    private $fechaHoraUltimaConexion;
    private $fechaHoraUltimaConexionAnterior;
    private $perfil;
    private $imagenUsuario;
    
    //CONSTRUCTOR
    public function __construct($codUsuario, $password, $descUsuario, $numConexiones, $fechaHoraUltimaConexion, $fechaHoraUltimaConexionAnterior, $perfil, $imagenUsuario = null) {
        $this->codUsuario = $codUsuario;
        $this->password = $password;
        $this->descUsuario = $descUsuario;
        $this->numConexiones = $numConexiones;
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
        $this->perfil = $perfil;
        $this->imagenUsuario = $imagenUsuario;
    }

    // GETTERS
    public function getCodUsuario() {
        return $this->codUsuario;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDescUsuario() {
        return $this->descUsuario;
    }

    public function getNumConexiones() {
        return $this->numConexiones;
    }

    public function getFechaHoraUltimaConexion() {
        return $this->fechaHoraUltimaConexion;
    }

    public function getFechaHoraUltimaConexionAnterior() {
        return $this->fechaHoraUltimaConexionAnterior;
    }

    public function getPerfil() {
        return $this->perfil;
    }

    public function getImagenUsuario() {
        return $this->imagenUsuario;
    }

    // SETTERS
    public function setPassword($password) {
        $this->password = $password;
    }

    public function setDescUsuario($descUsuario) {
        $this->descUsuario = $descUsuario;
    }

    public function setNumConexiones($numConexiones) {
        $this->numConexiones = $numConexiones;
    }

    public function setFechaHoraUltimaConexion($fechaHoraUltimaConexion) {
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
    }

    public function setFechaHoraUltimaConexionAnterior($fechaHoraUltimaConexionAnterior) {
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
    }

    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    public function setImagenUsuario($imagenUsuario) {
        $this->imagenUsuario = $imagenUsuario;
    }
}
?>