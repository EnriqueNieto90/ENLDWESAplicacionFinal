<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 02/02/2026
 * @description: Controlador para cambiar la contraseña.
 */

// BOTÓN CANCELAR Y VOLVER
if (isset($_REQUEST['cancelar']) || isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'cuenta'; 
    header('Location: index.php');
    exit;
}

// INICIALIZACIÓN DE VARIABLES
$entradaOK = true;
$aErrores = [
    'contrasenaActual' => null,
    'contrasenaNueva' => null,
    'repiteContrasena' => null
];

if (isset($_REQUEST['guardar'])) {
    
    // Validar contraseña actual
    $aErrores['contrasenaActual'] = validacionFormularios::validarPassword($_REQUEST['contrasenaActual'], 8, 1, 1, 1);
    
    // Comprobamos que sea la correcta en BBDD
    if ($aErrores['contrasenaActual'] == null) {
        $oUsuarioActual = $_SESSION['usuarioENLAplicacionFinal'];
        
        // Hash de lo que ha escrito el usuario
        $passIntroducidaHash = hash('sha256', $oUsuarioActual->getCodUsuario() . $_REQUEST['contrasenaActual']);
        
        if ($oUsuarioActual->getPassword() != $passIntroducidaHash) {
            $aErrores['contrasenaActual'] = "La contraseña actual no es correcta.";
            $entradaOK = false;
        }
    } else {
        $entradaOK = false;
    }

    // Validar nueva contraseña
    $aErrores['contrasenaNueva'] = validacionFormularios::validarPassword($_REQUEST['contrasenaNueva'], 8, 1, 1, 1);
    if ($aErrores['contrasenaNueva'] != null) {
        $entradaOK = false;
    }

    // Validar Repetición
    if ($_REQUEST['contrasenaNueva'] != $_REQUEST['repiteContrasena']) {
        $aErrores['repiteContrasena'] = "Las contraseñas no coinciden.";
        $entradaOK = false;
    }

    // Comprobación para que la nueva no sea igual a la vieja
    if ($entradaOK && $_REQUEST['contrasenaActual'] == $_REQUEST['contrasenaNueva']) {
        $aErrores['contrasenaNueva'] = "La nueva contraseña debe ser diferente a la actual.";
        $entradaOK = false;
    }

    // Si todo está bien cambiar la contraseña
    if ($entradaOK) {
        
        $oUsuarioModificado = UsuarioPDO::cambiarPassword($_SESSION['usuarioENLAplicacionFinal'], $_REQUEST['contrasenaNueva']);
        
        if ($oUsuarioModificado) {
            // Actualizamos la sesión con el usuario que tiene la contraseña nueva
            $_SESSION['usuarioENLAplicacionFinal'] = $oUsuarioModificado;
            
            // Redirigimos
            $_SESSION['paginaEnCurso'] = 'inicioPrivado';
            header('Location: index.php');
            exit;
        } else {
            $aErrores['contrasenaActual'] = "Error al actualizar en la base de datos.";
        }
    }
}
?>
