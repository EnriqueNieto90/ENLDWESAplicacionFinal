<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 15/12/2025
 * @description Punto de entrada de la aplicación.
 */

// CARGA DE CONFIGURACIONES
require_once 'config/confAPP.php';
require_once 'config/EDconfDBPDO.php';

// INICIAR O RECUPERAR SESIÓN
session_start();

// Si no hay página definida, cargamos el inicio público
if (!isset($_SESSION['paginaEnCurso'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
}

// CARGAR EL CONTROLADOR CORRESPONDIENTE
require_once $controller[$_SESSION['paginaEnCurso']];
?>