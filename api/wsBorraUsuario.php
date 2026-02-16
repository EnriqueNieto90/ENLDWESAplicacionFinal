<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 15/02/2026
 * @description: Web Service para eliminar un usuario por su código.
 */

// Cabecera para que JavaScript entienda que recibe JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// CARGA DE LIBRERÍA DE VALIDACIÓN
require_once '../core/231018libreriaValidacion.php';

// CARGA DEL MODELO
require_once '../config/EDconfDBPDO.php';
require_once '../model/Usuario.php';
require_once '../model/UsuarioPDO.php';
require_once '../model/DBPDO.php';
require_once '../model/ErrorApp.php';

$bEntradaOK = true;
$aRespuesta = [
    'exito' => false,
    'mensaje' => ''
];

// Comprobamos que llega el parámetro correcto
if (isset($_REQUEST['codUsuario'])) {
    if (validacionFormularios::comprobarAlfabetico($_REQUEST['codUsuario'], 10, 4, 1)) {
        $bEntradaOK = false;
        $aRespuesta['mensaje'] = 'Código de usuario no válido.';
    }
} else {
    $bEntradaOK = false;
    $aRespuesta['mensaje'] = 'El código de usuario es obligatorio.';
}

if ($bEntradaOK) {
    // Intentamos borrar el usuario de la DB
    if (UsuarioPDO::borrarUsuario($_REQUEST['codUsuario'])) {
        $aRespuesta['exito'] = true;
        $aRespuesta['mensaje'] = 'Usuario eliminado correctamente.';
    } else {
        $aRespuesta['mensaje'] = 'No se ha podido eliminar el usuario.';
    }
}

// Salida final
echo json_encode($aRespuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

