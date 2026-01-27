<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 18/01/2026
 * @description Punto de entrada de la aplicación.
 */

// CARGA DE CONFIGURACIONES
require_once 'config/confAPP.php';
require_once 'config/confDBPDO.php';

// INICIAR O RECUPERAR SESIÓN
session_start();

// Si no hay página definida, cargamos el inicio público
if (!isset($_SESSION['paginaEnCurso'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
}

// CARGAR EL CONTROLADOR CORRESPONDIENTE
if (isset($controller[$_SESSION['paginaEnCurso']])) {
    require_once $controller[$_SESSION['paginaEnCurso']];
} else {
    require_once $controller['inicioPublico'];
}

// PREPARAR DATOS COMUNES PARA EL LAYOUT
//Inicial y nombre del Usuario
$oUsuarioActivo = $_SESSION['usuarioENLAplicacionFinal'] ?? null;
$inicialUsuario = '?';
$descUsuario = '';

if ($oUsuarioActivo) {
    $inicialUsuario = $oUsuarioActivo->getInicialNombre();
    $descUsuario    = $oUsuarioActivo->getDescUsuario();
}

//Título de la página
$tituloActual = $titulos[$_SESSION['paginaEnCurso']] ?? 'Aplicación Final';

//Botón volver
$mostrarBotonVolver = !in_array($_SESSION['paginaEnCurso'], $aVistasSinBotonVolver);

//CARGAR LA VISTA PRINCIPAL (Layout)
require_once $view['layout'];
?>