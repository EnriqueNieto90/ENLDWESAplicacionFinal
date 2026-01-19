<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 19/01/2026
 * @description Controlador de la página de Error.
 */

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    unset($_SESSION['error']);
    header('Location: index.php');
    exit;
}

// Inicializar variables vacías por si acaso
$avError = [
    'codError' => 'Desconocido',
    'descError' => 'Ha ocurrido un error inesperado.',
    'archivoError' => '',
    'lineaError' => ''
];

// Si hay un objeto ErrorApp en la sesión, extraemos sus datos
if (isset($_SESSION['error']) && $_SESSION['error'] instanceof ErrorApp) {
    $oError = $_SESSION['error'];
    $avError = [
        'codError' => $oError->getCodError(),
        'descError' => $oError->getDescError(),
        'archivoError' => $oError->getArchivoError(),
        'lineaError' => $oError->getLineaError()
    ];
} elseif (isset($_SESSION['error'])) {
    $avError['descError'] = $_SESSION['error'];
}

require_once $view['layout'];
?>

