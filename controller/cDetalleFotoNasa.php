<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 01/02/2026
 * @description: Controlador para el detalle HD de la foto NASA.
 */

// BOTÓN VOLVER
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;
}

// RECUPERAR OBJETO DE LA SESIÓN
$oFotoNasa = $_SESSION['fotoNasaEnCurso'] ?? null;

// Si por alguna razón no hay foto (ej: acceso directo por URL), volvemos a REST para que la cargue
if ($oFotoNasa == null) {
    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;
}

// PREPARAR DATOS PARA LA VISTA
$avDetalleNasa = [
    'titulo' => $oFotoNasa->getTitulo(),
    'fecha'  => (new DateTime($oFotoNasa->getFecha()))->format('d/m/Y'),
    'urlHD'  => $oFotoNasa->getUrlHD(),
    'descripcion' => $oFotoNasa->getDescripcion()
];
?>

