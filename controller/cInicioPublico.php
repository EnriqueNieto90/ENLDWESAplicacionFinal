<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 18/01/2026
 * @description Controlador de la página de Inicio Público.
 */

// GESTIÓN DEL BOTÓN "INICIAR SESIÓN"
if (isset($_REQUEST['login'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    
    // Si ya hay sesión activa, ir directamente a inicio privado
    if (isset($_SESSION['usuarioENLAplicacionFinal'])) {
        $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    } else {
        $_SESSION['paginaEnCurso'] = 'login';
    }
    
    header('Location: index.php');
    exit;
}
?>