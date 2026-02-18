<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 07/02/2026
 * @description: Controlador para Modificar Departamento.
 */

// Control del botón CANCELAR
if (isset($_REQUEST['cancelar']) || isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

// Verificar que tenemos un departamento seleccionado
if (!isset($_SESSION['codDepartamentoEnCurso'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

// RECUPERACIÓN DEL OBJETO
$codDepartamento = $_SESSION['codDepartamentoEnCurso'];
$oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($codDepartamento);

// INICIALIZACIÓN DE VARIABLES
$entradaOK = true;
$aErrores = [
    'descDepartamento' => null,
    'volumenDeNegocio' => null
];

// PROCESAR FORMULARIO
if (isset($_REQUEST['aceptar'])) {

    // Validar Descripción
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento'], 255, 4, 1);
    
    // Comprobamos inmediatamente tras validar
    if ($aErrores['descDepartamento'] != null) {
        $entradaOK = false;
    }

    // Validar Volumen de Negocio
    // Reemplazamos coma por punto antes de validar
    $volumenFiltrado = str_replace(',', '.', $_REQUEST['volumenDeNegocio']);
    $aErrores['volumenDeNegocio'] = validacionFormularios::comprobarFloat($volumenFiltrado, 100000000000000000000, 0, 1);

    // Comprobamos inmediatamente tras validar
    if ($aErrores['volumenDeNegocio'] != null) {
        $entradaOK = false;
    }

    // EJECUCIÓN DE LA MODIFICACIÓN
    if ($entradaOK) {
        // Si todo está bien, llamamos al modelo
        if (DepartamentoPDO::modificaDepartamento($codDepartamento, $_REQUEST['descDepartamento'], (float)$volumenFiltrado)) {
            $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
            header('Location: index.php');
            exit;
        } else {
            // Error en BBDD
            $aErrores['descDepartamento'] = "Error al modificar en la base de datos.";
        }
    }
} else {
    // Si no se ha pulsado aceptar (primera carga), la entrada no es OK para no procesar
    $entradaOK = false;
}

// PREPARAR DATOS PARA LA VISTA
// Si venimos de un submit ($entradaOK puede ser false por errores), mostramos lo que escribió el usuario.
// Si es la primera vez, mostramos los datos de la BBDD ($oDepartamento).
$descMostrar = isset($_REQUEST['aceptar']) ? $_REQUEST['descDepartamento'] : $oDepartamento->getDescDepartamento();
$volumenMostrar = isset($_REQUEST['aceptar']) ? $_REQUEST['volumenDeNegocio'] : $oDepartamento->getVolumenDeNegocio();

$avModificarDepartamento = [
    'codDepartamento' => $oDepartamento->getCodDepartamento(),
    'descDepartamento' => $descMostrar,
    'volumenDeNegocio' => $volumenMostrar,
    'fechaCreacion' => (new DateTime($oDepartamento->getFechaCreacionDepartamento()))->format('d/m/Y')
];
?>

