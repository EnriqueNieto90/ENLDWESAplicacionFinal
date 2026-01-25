<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 19/01/2026
 * @description Controlador para la .
 */

// Si se pulsa el botón de volver
if (isset($_REQUEST['volver'])) {
    // Regresamos a la página que teníamos guardada como anterior
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}
?>
