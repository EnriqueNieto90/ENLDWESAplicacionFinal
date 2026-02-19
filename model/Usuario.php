<?php
/**
 * Clase entidad Usuario.
 * * Representa a un usuario dentro del sistema, independientemente de su perfil
 * (Usuario registrado o Administrador). Sirve como objeto de transferencia de datos 
 * (DTO) almacenando las credenciales, información de acceso y preferencias.
 *
 * @author Enrique Nieto Lorenzo
 * @since 18/01/2026
 * @version 1.0.0
 */
class Usuario {
    
    //ATRIBUTOS
    
    /** @var string Código único o nombre de usuario (PK). */
    private $codUsuario;
    
    /** @var string Contraseña del usuario (generalmente cifrada con hash). */
    private $password;
    
    /** @var string Nombre real o descripción asociada al usuario. */
    private $descUsuario;
    
    /** @var int Número total de veces que el usuario ha iniciado sesión con éxito. */
    private $numConexiones;
    
    /** @var string Fecha y hora del inicio de sesión actual. */
    private $fechaHoraUltimaConexion;
    
    /** @var string Fecha y hora del último inicio de sesión previo al actual. */
    private $fechaHoraUltimaConexionAnterior;
    
    /** @var string Perfil o rol del usuario en el sistema (ej. "usuario" o "administrador"). */
    private $perfil;
    
    /** @var string|null Imagen de avatar del usuario (ruta o codificada en Base64). Null si no tiene. */
    private $imagenUsuario;
    
    //CONSTRUCTOR
    
    /**
     * Constructor de la clase Usuario.
     * * Instancia un nuevo objeto Usuario con la información extraída de la base de datos.
     *
     * @param string      $codUsuario                      Identificador del usuario.
     * @param string      $password                        Contraseña cifrada.
     * @param string      $descUsuario                     Nombre descriptivo.
     * @param int         $numConexiones                   Contador de logins exitosos.
     * @param string      $fechaHoraUltimaConexion         Marca de tiempo del login actual.
     * @param string      $fechaHoraUltimaConexionAnterior Marca de tiempo del login anterior.
     * @param string      $perfil                          Rol de privilegios.
     * @param string|null $imagenUsuario                   (Opcional) Imagen de perfil asociada.
     */
    public function __construct($codUsuario, $password, $descUsuario, $numConexiones, $fechaHoraUltimaConexion, $fechaHoraUltimaConexionAnterior, $perfil, $imagenUsuario=null) {
        $this->codUsuario                      = $codUsuario;
        $this->password                        = $password;
        $this->descUsuario                     = $descUsuario;
        $this->numConexiones                   = $numConexiones;
        $this->fechaHoraUltimaConexion         = $fechaHoraUltimaConexion;
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
        $this->perfil                          = $perfil;
        $this->imagenUsuario                   = $imagenUsuario;
    }

    // GETTERS
    
    /**
     * Obtiene el código identificador del usuario.
     * @return string
     */
    public function getCodUsuario() {
        return $this->codUsuario;
    }

    /**
     * Obtiene la contraseña del usuario.
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Obtiene la descripción o nombre del usuario.
     * @return string
     */
    public function getDescUsuario() {
        return $this->descUsuario;
    }

    /**
     * Obtiene el número total de conexiones al sistema.
     * @return int
     */
    public function getNumConexiones() {
        return $this->numConexiones;
    }

    /**
     * Obtiene la fecha y hora de la conexión más reciente.
     * @return string
     */
    public function getFechaHoraUltimaConexion() {
        return $this->fechaHoraUltimaConexion;
    }

    /**
     * Obtiene la fecha y hora de la conexión penúltima (anterior a la actual).
     * @return string
     */
    public function getFechaHoraUltimaConexionAnterior() {
        return $this->fechaHoraUltimaConexionAnterior;
    }

    /**
     * Obtiene el perfil o rol de seguridad del usuario.
     * @return string
     */
    public function getPerfil() {
        return $this->perfil;
    }

    /**
     * Obtiene la imagen de perfil del usuario.
     * @return string|null
     */
    public function getImagenUsuario() {
        return $this->imagenUsuario;
    }
    
    /**
     * Obtiene la primera letra de la descripción del usuario en mayúscula.
     * * Función auxiliar útil para generar avatares de texto automáticos en las vistas 
     * (ej. menú circular de cuenta de usuario).
     * * @return string Inicial del nombre o '?' si no hay descripción.
     */
    public function getInicialNombre() {
        return !empty($this->descUsuario) ? mb_strtoupper(mb_substr($this->descUsuario, 0, 1)) : '?';
    }

    // SETTERS
    
    /**
     * Modifica la contraseña del usuario.
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Modifica la descripción o nombre del usuario.
     * @param string $descUsuario
     */
    public function setDescUsuario($descUsuario) {
        $this->descUsuario = $descUsuario;
    }

    /**
     * Establece el número de conexiones del usuario.
     * @param int $numConexiones
     */
    public function setNumConexiones($numConexiones) {
        $this->numConexiones = $numConexiones;
    }

    /**
     * Establece la fecha y hora de la última conexión.
     * @param string $fechaHoraUltimaConexion
     */
    public function setFechaHoraUltimaConexion($fechaHoraUltimaConexion) {
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
    }

    /**
     * Establece la fecha y hora de la conexión anterior.
     * @param string $fechaHoraUltimaConexionAnterior
     */
    public function setFechaHoraUltimaConexionAnterior($fechaHoraUltimaConexionAnterior) {
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
    }

    /**
     * Modifica el perfil de seguridad del usuario.
     * @param string $perfil
     */
    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    /**
     * Actualiza la imagen de perfil del usuario.
     * @param string|null $imagenUsuario
     */
    public function setImagenUsuario($imagenUsuario) {
        $this->imagenUsuario = $imagenUsuario;
    }
}
?>