<?php

/**
 * @author: Enrique Nieto Lorenzo
 * @since: 05/02/2026
 * @description: Web Service de Buscar Usuario por descripción.
 */
// CARGA DE LIBRERÍA DE VALIDACIÓN
require_once '../core/231018libreriaValidacion.php';

// CARGA DEL MODELO
require_once '../config/EDconfDBPDO.php';
require_once '../model/Usuario.php';
require_once '../model/UsuarioPDO.php';
require_once '../model/DBPDO.php';

$bEntradaOK = true;

if (isset($_REQUEST[''])) {

    if (!validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'])) {
        $bEntradaOK = false;
    }
}

// Si el usuario ha enviado una nueva búsqueda, sobrescribimos la variable y actualizamos la sesión
if ($bEntradaOK) {
// Recuperar los datos de la DB
    $aUsuariosEncontrados = UsuarioPDO::buscaUsuariosPorDesc($_REQUEST['descUsuario'] ?? '');

    $aUsuariosPorDescripcion = [];

    if ($aUsuariosEncontrados) {
        foreach ($aUsuariosEncontrados as $oUsuario) {
            $aUsuariosPorDescripcion[] = [
                'codUsuario' => $oUsuario->getCodUsuario(),
                'password' => $oUsuario->getPassword(),
                'descUsuario' => $oUsuario->getDescUsuario(),
                'numConexiones' => $oUsuario->getNumConexiones(),
                'fechaHoraUltimaConexion' => $oUsuario->getFechaHoraUltimaConexion(),
                'fechaHoraUltimaConexionAnterior' => $oUsuario->getFechaHoraUltimaConexionAnterior(),
                'perfil' => $oUsuario->getPerfil(),
                'imagenUsuario' => $oUsuario->getImagenUsuario()
            ];
        }
    }
}
print_r(json_encode($aUsuariosPorDescripcion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
?>

