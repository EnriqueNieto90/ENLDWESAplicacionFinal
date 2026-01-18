<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Controlador de Inicio Privado.
 */

//Si no hay usuario logueado, mandar al login
if (!isset($_SESSION['usuarioENLAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

//BOTÓN CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    session_destroy(); // Destruir la sesión
    session_start(); // Iniciar una nueva limpia para redirigir
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

//BOTÓN DETALLE
if (isset($_REQUEST['detalle'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'detalle';
    header('Location: index.php');
    exit;
}

// PREPARAR DATOS PARA LA VISTA
$oUsuario = $_SESSION['usuarioENLAplicacionFinal'];

$avInicioPrivado = [
    'descUsuario'                     => $oUsuario->getDescUsuario(),
    'numConexiones'                      => $oUsuario->getNumConexiones(),
    'fechaHoraUltimaConexionAnterior' => $oUsuario->getFechaHoraUltimaConexionAnterior(),
];

//CARGAR VISTA
require_once $view['layout'];
?>