<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 26/01/2026
 * @description: Controlador de Mi Cuenta.
 */

// Si no hay usuario logueado, mandar al login
if (!isset($_SESSION['usuarioENLAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
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

// BOTÓN CANCELAR
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['cambiarPassword'])) {
    $_SESSION['paginaAnterior'] = 'cuenta';
//    $_SESSION['paginaEnCurso'] = 'cambiarPassword';
    $_SESSION['paginaEnCurso'] = 'wip';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['borrarCuenta'])) {
    $_SESSION['paginaAnterior'] = 'cuenta';
//    $_SESSION['paginaEnCurso'] = 'borrarCuenta';
    $_SESSION['paginaEnCurso'] = 'wip';
    header('Location: index.php');
    exit;
}

// RECUPERAR DATOS DEL USUARIO ACTUAL
$oUsuario = $_SESSION['usuarioENLAplicacionFinal'];
$entradaOK = true;
$aErrores = ['descUsuario' => null];

// Si pulsamos guardar modificamos el usuario
if (isset($_REQUEST['aceptar'])) {

    // Validar el nombre que introducimos para la modificación
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'], 255, 3, 1);

    // Comprobar errores
    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        // Llamada al Modelo para actualizar
        $oUsuarioActualizado = UsuarioPDO::modificarUsuario($oUsuario, $_REQUEST['descUsuario']);

        if ($oUsuarioActualizado) {
            // Actualizamos la sesión con el objeto nuevo
            $_SESSION['usuarioENLAplicacionFinal'] = $oUsuarioActualizado;
            
            // Volvemos al inicio privado
            $_SESSION['paginaEnCurso'] = 'inicioPrivado';
            header('Location: index.php');
            exit;
        } else {
             $aErrores['descUsuario'] = "No se ha podido modificar el usuario.";
        }
    }
} else {
    $entradaOK = false;
}

// PREPARAR DATOS PARA LA VISTA
$avMiCuenta = [
    'codUsuario' => $oUsuario->getCodUsuario(),
    'descUsuario' => $_REQUEST['descUsuario'] ?? $oUsuario->getDescUsuario(),
    'perfil' => $oUsuario->getPerfil(),
    'numConexiones' => $oUsuario->getNumConexiones(),
    'fechaUltimaConexion' => $oUsuario->getFechaHoraUltimaConexion()->format('d/m/Y H:i'),
    'inicial' => $oUsuario->getInicialNombre()
];

?>