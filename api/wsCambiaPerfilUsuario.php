<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 16/02/2026
 * @description: Web Service para cambiar el perfil de un usuario.
 */

// Cabecera para que JavaScript entienda que recibe JSON
header("Content-Type: application/json; charset=UTF-8");

// CARGA DE LIBRERÍA DE VALIDACIÓN
require_once '../core/231018libreriaValidacion.php';

// CARGA DEL MODELO
require_once '../config/confDBPDO.php';
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

if (!isset($_REQUEST['nuevoPerfil'])) {
    $bEntradaOK = false;
    $aRespuesta['mensaje'] = 'El nuevo perfil es obligatorio.';
}

// Comprobamos que el perfil sea uno de los dos válidos
if ($bEntradaOK) {
    $nuevoPerfil = $_REQUEST['nuevoPerfil'];
    
    if ($nuevoPerfil !== 'usuario' && $nuevoPerfil !== 'administrador') {
        $bEntradaOK = false;
        $aRespuesta['mensaje'] = 'El perfil debe ser "usuario" o "administrador".';
    }
}

if ($bEntradaOK) {
    $codUsuario = trim($_REQUEST['codUsuario']);

    // Intentamos cambiar el perfil en la DB
    if (UsuarioPDO::cambiarPerfil($codUsuario, $nuevoPerfil)) {
        $aRespuesta['exito'] = true;
        $aRespuesta['mensaje'] = 'Perfil cambiado correctamente.';
    } else {
        $aRespuesta['mensaje'] = 'No se ha podido cambiar el perfil.';
    }
}

// Salida final
echo json_encode($aRespuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

