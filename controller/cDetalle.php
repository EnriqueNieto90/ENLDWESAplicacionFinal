<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 15/12/2025
 * @description: Controlador de Detalle.
 */

//BOTÓN VOLVER
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
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

