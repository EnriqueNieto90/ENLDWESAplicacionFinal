<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 11/01/2026
 * @description Controlador de la página de Inicio Público.
 */

// GESTIÓN DE IDIOMA
// Crear cookie por defecto si no existe
if (!isset($_COOKIE['idioma'])) {
    setcookie("idioma", "ES", time() + 604800);
    header('Location: indexLoginLogoff.php');
    exit;
}

// Cambiar idioma si el usuario selecciona otro
if (isset($_REQUEST['idioma'])) {
    setcookie("idioma", $_REQUEST['idioma'], time() + 604800);
    header('Location: indexLoginLogoff.php');
    exit;
}

// GESTIÓN DEL BOTÓN "INICIAR SESIÓN"
if (isset($_REQUEST['iniciarSesion'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    
    // Si ya hay sesión activa, ir directamente a inicio privado
    if (isset($_SESSION['usuarioENLLoginLogoff'])) {
        $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    } else {
        $_SESSION['paginaEnCurso'] = 'login';
    }
    
    header('Location: indexLoginLogoff.php');
    exit;
}

// CARGAR VISTA
require_once $view['layout'];
?>