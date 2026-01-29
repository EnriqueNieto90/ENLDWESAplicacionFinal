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

// Por defecto creamos la fecha de hoy
$oFechaNasa = new DateTime(); 

// Si ya hay una fecha en la sesión (porque el usuario eligió una antes), usamos esa
if (isset($_SESSION['fechaNasa'])) {
    $oFechaNasa = $_SESSION['fechaNasa'];
}

/* Llamada inicial a la API
   Cargamos el objeto fotoNasa con la fecha que tengamos (hoy o la de sesión).
   Lo hacemos antes del formulario para mostrar siempre la foto actual al entrar. */
$fechaNasaFormateada = $oFechaNasa->format('Y-m-d');
$oFotoNasa = REST::apiNasa($fechaNasaFormateada);

// Inicializamos variables de control de errores
$entradaOK = true;
$aErrores = ['fechaNasa' => null];

// Procesamiento del Formulario
if (isset($_REQUEST['enviarNasa'])) {

    // Creamos objetos DateTime para la validación (Actual y Mínima)
    $oFechaActual = new DateTime();
    $oFechaMinima = new DateTime('1995-06-16'); // Primera foto de la APOD

    // Validamos la fecha
    $aErrores['fechaNasa'] = validacionFormularios::validarFecha(
        $_REQUEST['fechaNasa'], 
        $oFechaActual->format('m/d/Y'), 
        $oFechaMinima->format('m/d/Y'), 
        1
    );

    // Comprobamos si hay errores
    if ($aErrores['fechaNasa'] != null) {
        $entradaOK = false;
    }

    // Si la entrada es válida -> Guardar en Sesión y Recargar
    if ($entradaOK) {
        // Guardamos la nueva fecha como objeto DateTime en la sesión
        $_SESSION['fechaNasa'] = new DateTime($_REQUEST['fechaNasa']);
        
        // Recargamos la página para limpiar el POST
        $_SESSION['paginaEnCurso'] = 'rest';
        header('Location: index.php');
        exit;
    }
} else {
    $entradaOK = false;
}

// Control de Error de API
// Si $oFotoNasa es null, creamos un objeto vacío para que no rompa la vista
if (!isset($oFotoNasa) || is_null($oFotoNasa)) {
    $oFotoNasa = new FotoNasa(
        'Foto no disponible', 
        'webroot/images/error_nasa.jpg',
        $oFechaNasa->format('Y-m-d'),
        'No se ha podido conectar con el servidor de la NASA. Inténtelo más tarde.',
        null
    );
}

// Preparación de datos para la Vista
$avRest = [
    'fechaNasa' => $oFechaNasa->format('Y-m-d'),
    'fotoNasa'  => $oFotoNasa,
    'error'     => $aErrores['fechaNasa']
];
?>