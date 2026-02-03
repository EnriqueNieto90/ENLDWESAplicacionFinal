<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 03/02/2026
 * @description: Controlador para añadir un nuevo departamento.
 */

// Control de botón Volver
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// BOTÓN CANCELAR
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

// Inicializamos las variables de Departamento
$entradaOK = true;
$aErrores = [
    'codDepartamento' => null,
    'descDepartamento' => null,
    'volumenDeNegocio' => null
];

// procesamos el formulario si usuario da a aceptar
if (isset($_REQUEST['crear'])) {

    // Validar Código 3 letras obligatorias
    $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], 3, 3, 1);
    
    // Si el formato es correcto, comprobamos que NO exista en la BBDD
    if ($aErrores['codDepartamento'] == null) {
        // Convertimos a mayúsculas para asegurar consistencia
        $_REQUEST['codDepartamento'] = strtoupper($_REQUEST['codDepartamento']);
        
        if (DepartamentoPDO::validaCodNoExiste($_REQUEST['codDepartamento'])) {
            $aErrores['codDepartamento'] = "El código ya existe.";
            $entradaOK = false;
        }
    } else {
        $entradaOK = false;
    }

    // Validar Descripción Alfanumérico, mín 4, máx 255
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento'], 255, 4, 1);
    if ($aErrores['descDepartamento'] != null) {
        $entradaOK = false;
    }

    // Validar Volumen de Negocio
    // Reemplazamos coma por punto antes de validar para permitir ambos formatos
    $volumenFiltrado = str_replace(',', '.', $_REQUEST['volumenDeNegocio']);
    $aErrores['volumenDeNegocio'] = validacionFormularios::comprobarFloat($volumenFiltrado, 1000000000, 0, 1);
    
    if ($aErrores['volumenDeNegocio'] != null) {
        $entradaOK = false;
    }

    // Si toda la validación es ok creamos el departamento nuevo
    if ($entradaOK) {
        $oDepartamentoNuevo = DepartamentoPDO::altaDepartamento(
            $_REQUEST['codDepartamento'],
            $_REQUEST['descDepartamento'],
            (float)$volumenFiltrado
        );

        if ($oDepartamentoNuevo) {
            // Volvemos al mantenimiento tras la creación
            $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
            header('Location: index.php');
            exit;
        } else {
            // Error genérico de BBDD
            $aErrores['codDepartamento'] = "Error al insertar el departamento.";
        }
    }
}
?>
