<?php

/**
 * @author: Enrique Nieto Lorenzo
 * @since: 05/02/2026
 * @description: Web Service de Buscar Usuario por descripción.
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

$bEntradaOK = true;
$descripcionBuscada = "";

//Comprobamos que llega el parámetro correcto
if (isset($_REQUEST['descUsuario'])) {
    
    if (!validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 1, 0)) {
        $bEntradaOK = false;
    } else {
        // Si es válido, guardamos la variable
        $descripcionBuscada = $_REQUEST['descUsuario'];
    }
}

if ($bEntradaOK) {
// Recuperar los datos de la DB
    $aUsuariosEncontrados = UsuarioPDO::buscaUsuariosPorDesc($descripcionBuscada);

    if ($aUsuariosEncontrados) {
        foreach ($aUsuariosEncontrados as $oUsuario) {
            $aUsuariosPorDescripcion[] = [
                'codUsuario' => $oUsuario->getCodUsuario(),
                'descUsuario' => $oUsuario->getDescUsuario(),
                'numConexiones' => $oUsuario->getNumConexiones(),
                'fechaHoraUltimaConexion' => $oUsuario->getFechaHoraUltimaConexion(),
                'perfil' => $oUsuario->getPerfil()
            ];
        }
    }
}
// Salida final
echo json_encode($aUsuariosPorDescripcion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

