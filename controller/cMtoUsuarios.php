<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 05/02/2026
 * @description: Controlador de Mantenimiento de Usuarios.
 */

// Control de botón Volver
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}


?>
