<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 02/02/2026
 * @description: Controlador para el borrado de cuenta.
 */

// BOTÓN CANCELAR Y VOLVER
if (isset($_REQUEST['cancelar']) || isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'] ?? 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// SI CONFIRMA ELIMINAR
if (isset($_REQUEST['eliminar'])) {
    
    if (UsuarioPDO::borrarUsuario($_SESSION['usuarioENLAplicacionFinal'])) {
        session_destroy();
        session_start(); 
        $_SESSION['paginaEnCurso'] = 'login';
        
        header('Location: index.php');
        exit;
    } else {
        $error = "No se ha podido borrar la cuenta. Inténtelo más tarde.";
    }
}
?>
