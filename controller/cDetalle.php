<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 15/12/2025
 * @description: Controlador de Detalle.
 */

//Si no hay usuario logueado, mandar al login
if (!isset($_SESSION['usuarioENLAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

//BOTÓN CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    session_destroy();
    session_start();
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

//BOTÓN VOLVER
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

// PREPARAR DATOS PARA LA VISTA EN UN ARRAY
// Capturamos phpinfo usando Output Buffering para que no se imprima directamente
ob_start();             // Abrimos el buffer
phpinfo();              // Ejecutamos la función y se guarda en memoria
$pInfo = ob_get_clean(); // Obtenemos el contenido y limpiamos el buffer

// Creamos el array de vista
$avDetalle = [
    'session' => $_SESSION,
    'cookie'  => $_COOKIE, 
    'server'  => $_SERVER,
    'phpInfo' => $pInfo  
];
?>

