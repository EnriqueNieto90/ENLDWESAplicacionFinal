<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 11/01/2026
 * @description: Controlador del Login. Gestiona la autenticación.
 */

//SI SE PULSA CANCELAR Volver a Inicio Público
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: indexLoginLogoff.php');
    exit;
}

//PROCESO DE LOGIN
$entradaOK = true;
$aErrores = ['usuario' => null, 'password' => null];

if (isset($_REQUEST['entrar'])) {
    // Validar el formato de campos
    $aErrores['usuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], 50, 1, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 20, 4, 1, 1);

    // Comprobar si hay errores
    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            $entradaOK = false;
            $_REQUEST['password'] = ''; // Limpiar contraseña por seguridad
        }
    }
    //SI LOS DATOS SON VÁLIDOS CONSULTAR BBDD
    if ($entradaOK) {
        $oUsuarioValido = UsuarioPDO::validarUsuario($_REQUEST['usuario'], $_REQUEST['password']);

        // Si no se encuentra en la BBDD entradaOK es false
        if (!isset($oUsuarioValido)) {
            $entradaOK = false;
        }
    }
} else {
    $entradaOK = false; 
}

// LOGIN CORRECTO. Guardamos usuario en sesión y redirigimos
if ($entradaOK) {
    $_SESSION['usuarioENLLoginLogoff'] = $oUsuarioValido;
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
        
    header('Location: indexLoginLogoff.php');
    exit;
}

//CARGAR LA VISTA
require_once $view['layout'];
?>
