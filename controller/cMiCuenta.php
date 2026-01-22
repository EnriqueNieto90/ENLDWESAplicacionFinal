<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 22/01/2026
 * @description Controlador para mi cuenta de usuario.
 */

// SI SE PULSA CANCELAR
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

$entradaOK = true;
$aErrores = [
    'codUsuario'  => null,
    'descUsuario' => null,
    'password'    => null
];

// SI SE PULSA CREAR CUENTA
if (isset($_REQUEST['registrarse'])) {
    
    // Validar formato de los campos
    $aErrores['codUsuario']  = validacionFormularios::comprobarAlfabetico($_REQUEST['codUsuario'], 10, 4, 1);
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descUsuario'], 255, 4, 1);
    $aErrores['password']    = validacionFormularios::validarPassword($_REQUEST['password'], 8, 4, 1, 1);
    
    // Comprobar si hay errores de formato
    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            $entradaOK = false;
            $_REQUEST['password'] = ""; // Limpiar contraseña
        }
    }
    
    // Validar lógica de negocio (Usuario duplicado)
    if ($entradaOK) {
        if (!UsuarioPDO::validarCodNoExiste($_REQUEST['codUsuario'])) {
            $aErrores['codUsuario'] = "Ese código de usuario ya está en uso.";
            $entradaOK = false;
        }
    }

    // Si todo está OK, insertar en BBDD
    if ($entradaOK) {
        $oUsuarioNuevo = UsuarioPDO::altaUsuario(
            $_REQUEST['codUsuario'], 
            $_REQUEST['password'], 
            $_REQUEST['descUsuario']
        );

        if ($oUsuarioNuevo) {
            // Login automático tras registro
            $_SESSION['usuarioENLAplicacionFinal'] = $oUsuarioNuevo;
            $_SESSION['paginaEnCurso'] = 'inicioPrivado';
            header('Location: index.php');
            exit;
        } else {
            // Error en base de datos
            $_SESSION['paginaEnCurso'] = 'error'; // O manejar el error aquí
            exit;
        }
    }

} else {
    $entradaOK = false;
}

require_once $view['layout'];
?>

