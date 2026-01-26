<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Controlador de la página de Error.
 */

// Inicializamos el array de datos para la vista
$avError = [
    'codError' => '',
    'descError' => '',
    'archivoError' => '',
    'lineaError' => ''
];

// Se recogen los datos del error guardados en la sesión
if (isset($_SESSION['error'])) {
    $oError = $_SESSION['error'];

    // Aseguramos que es un objeto de tipo ErrorApp antes de llamar a los métodos
    if (is_object($oError) && get_class($oError) == 'ErrorApp') {
        $avError = [
            'codError'     => $oError->getCodError(),
            'descError'    => $oError->getDescError(),
            'archivoError' => $oError->getArchivoError(),
            'lineaError'   => $oError->getLineaError()
        ];
    }

    // Borramos el error de la sesión para que no persista
    unset($_SESSION['error']);
}

// BOTÓN CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    session_destroy();
    session_start();
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// Control de botón Volver
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
?>

