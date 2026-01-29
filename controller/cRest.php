<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 21/01/2026
 * @description: Controlador para la API REST
 */

// Control de sesión (Si no está logueado, al login)
if (!isset($_SESSION['usuarioENLAplicacionFinal'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

// BOTÓN CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    session_destroy();
    session_start();
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// Comprobamos si la sesión "fotoNasa" está vacia.
if(empty($_SESSION['fotoNasa'])){
    // Se obtiene la fecha de hoy para valores.
    $fechaHoy = new DateTime();
    $fechaHoyFormateada = $fechaHoy->format('Y-m-d');
    $_SESSION['fotoNasa'] = REST::apiNasa($fechaHoyFormateada);
}

// Control de botón Volver
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// BOTÓN CUENTA
if (isset($_REQUEST['cuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'wip'; 
    header('Location: index.php');
    exit;
}

$entradaOk = true;
// Inicializamos las variables de control.
$aErrores = [
    'fechaNasa' => null
];

$oFotoNasa = null;

// Se obtiene la fecha de hoy para valores.
$fechaHoy = new DateTime();
$fechaHoyFormateada = $fechaHoy->format('Y-m-d');
$fechaNasa = $fechaHoyFormateada; // Fecha formateada del día de hoy.

// Comprobamos si el botón "btnFecha" ha sido pulsado.
if(isset($_REQUEST['enviarNasa'])){
    $entradaOk = true;
    $aErrores['fechaNasaEnCurso'] = validacionFormularios::validarFecha($_REQUEST['fechaNasaEnCurso'], $fechaHoyFormateada, '1995-06-16', 1);
    
    if($aErrores['fechaNasaEnCurso'] != null){
        $entradaOk = false;
    }
    
        
    
    if($entradaOk){
        $fechaNasa = $_REQUEST['fechaNasaEnCurso'];
        $oFotoNasa = REST::apiNasa($fechaNasa);
        $_SESSION['fotoNasa'] = $oFotoNasa;
    }
}





// Se crea un array con todos los datos que se le pasan a la vista.
$avRest = [
    'fotoNasaEnCursoTitulo' => $_SESSION['fotoNasa']->getTitulo(),
    'fotoNasaEnCursoUrl' => $_SESSION['fotoNasa']->getUrl(),
    'fotoNasaEnCursoUrlHD' => $_SESSION['fotoNasa']->getUrlHD(),
    'fotoNasaEnCursoDescripcion' => $_SESSION['fotoNasa']->getDescripcion(),
    'fechaNasaEnCurso' => $_SESSION['fotoNasa']->getFecha(),
    'errorNasa' => $aErrores['fechaNasa']
];

?>