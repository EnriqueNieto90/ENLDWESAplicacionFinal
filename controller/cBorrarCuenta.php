<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 07/02/2026
 * @description: Controlador para el borrado de cuenta.
 */

// BOTÓN CANCELAR Y VOLVER
if (isset($_REQUEST['cancelar']) || isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'] ?? 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// PROCESO DE ELIMINACIÓN
if (isset($_REQUEST['eliminar'])) {
    // Intentamos borrar el usuario que está en sesión
    if (UsuarioPDO::borrarUsuario($_SESSION['usuarioENLAplicacionFinal']->getCodUsuario())) {
        // Si se borra, destruimos sesión y al login
        session_destroy();
        session_start();
        $_SESSION['paginaEnCurso'] = 'inicioPublico';

        header('Location: index.php');
        exit;
    } else {
        $error = "No se ha podido borrar la cuenta.";
    }
}

// ARRAY PARA LA VISTA
$oUsuario = $_SESSION['usuarioENLAplicacionFinal'];

// Formateamos la fecha de última conexión si existe
$fechaUltima = $oUsuario->getFechaHoraUltimaConexion();
$fechaUltimaStr = ($fechaUltima instanceof DateTime) ? $fechaUltima->format('d/m/Y H:i:s') : '-';

$avBorrarCuenta = [
    'codUsuario' => $oUsuario->getCodUsuario(),
    'perfil' => $oUsuario->getPerfil(),
    'descUsuario' => $oUsuario->getDescUsuario(),
    'numConexiones' => $oUsuario->getNumConexiones(),
    'ultimaConexion' => $fechaUltimaStr
];
?>
