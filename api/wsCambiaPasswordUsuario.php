<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 16/02/2026
 * @description: Web Service para cambiar la contraseña de un usuario.
 */

// Cabecera para que JavaScript entienda que recibe JSON
header("Content-Type: application/json; charset=UTF-8");

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

// Comprobamos que llegan los parámetros correctos
if (!isset($_REQUEST['codUsuario'])) {
    $bEntradaOK = false;
    $aRespuesta['mensaje'] = 'El código de usuario es obligatorio.';
}

if (!isset($_REQUEST['nuevaPassword'])) {
    $bEntradaOK = false;
    $aRespuesta['mensaje'] = 'La nueva contraseña es obligatoria.';
}

if ($bEntradaOK) {
    $codUsuario = $_REQUEST['codUsuario'];
    $nuevaPassword = $_REQUEST['nuevaPassword'];

    // Intentamos cambiar la contraseña en la DB
    if (UsuarioPDO::cambiarPassword($codUsuario, $nuevaPassword)) {
        $aRespuesta['exito'] = true;
        $aRespuesta['mensaje'] = 'Contraseña cambiada correctamente.';
    } else {
        $aRespuesta['mensaje'] = 'No se ha podido cambiar la contraseña.';
    }
}

// Salida final
echo json_encode($aRespuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

