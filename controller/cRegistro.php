<?php

/**
 * @author Enrique Nieto Lorenzo
 * @since 19/01/2026
 * @description Controlador para el registro de nuevos usuarios.
 */
// SI SE PULSA CANCELAR (Ir al Login)
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

$entradaOK = true;

$aErrores = [
    'codUsuario' => null,
    'descUsuario' => null,
    'password' => null,
    'repetirPassword' => null,
    'preguntaSeguridad' => null
];

$aRespuestas = [
    'codUsuario' => '',
    'descUsuario' => '',
    'password' => '',
    'repetirPassword' => '',
    'preguntaSeguridad' => ''
];

// SI SE PULSA REGISTRARSE
if (isset($_REQUEST['registrarse'])) {

    // Validar formato de los campos individuales
    $aErrores['codUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codUsuario'], 10, 4, 1);
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'], 255, 4, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 8, 4, 1, 1);
    
    // Comporbar que el campo repetir contraseña no esté vacío
    if (empty($_REQUEST['repetirPassword'])) {
        $aErrores['repetirPassword'] = "Debe repetir la contraseña.";
    } else if ($_REQUEST['password'] !== $_REQUEST['repetirPassword']) { // Comprobar si las contraseñas coinciden
        $aErrores['repetirPassword'] = "Las contraseñas no coinciden.";
        $entradaOK = false;
    }
    
    // Comporbar que el campo respuesta de seguridad no esté vacío
    if (empty($_REQUEST['preguntaSeguridad'])) {
        $aErrores['preguntaSeguridad'] = "Debe escribir la respuesta.";
    } else if ($_REQUEST['preguntaSeguridad'] !== PALABRA_SEGURIDAD) { // Comprobar si la respuesta coincide
        $aErrores['preguntaSeguridad'] = "La respuesta de seguridad no es correcta";
        $entradaOK = false;
    }
    
    // Validación para ver si el usuario existe. Solo consultamos si el formato del código es válido para ahorrar consultas
    if ($aErrores['codUsuario'] == null) {
        if (!UsuarioPDO::validarCodNoExiste($_REQUEST['codUsuario'])) {
            $aErrores['codUsuario'] = "El usuario ya existe.";
            $entradaOK = false;
        }
    }

    // Comprobar si hubo errores de formato y si no rellenar array de respuestas
    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            $entradaOK = false;
            // Limpiamos contraseñas por seguridad
            $_REQUEST['password'] = "";
            $_REQUEST['repetirPassword'] = "";
        } else {
            if (isset($_REQUEST[$campo])) {
                $aRespuestas[$campo] = $_REQUEST[$campo];
            }
        }
    }

} else {
    $entradaOK = false;
}

// Si todo está OK, insertar en BBDD
if ($entradaOK) {
    $oUsuarioNuevo = UsuarioPDO::altaUsuario(
                    $_REQUEST['codUsuario'],
                    $_REQUEST['password'],
                    $_REQUEST['descUsuario']
    );

    if ($oUsuarioNuevo) {
        // Login automático tras el registro
        $_SESSION['usuarioENLAplicacionFinal'] = $oUsuarioNuevo;
        $_SESSION['paginaEnCurso'] = 'inicioPrivado';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['paginaEnCurso'] = 'error';
        header('Location: index.php');
        exit;
    }
}
?>