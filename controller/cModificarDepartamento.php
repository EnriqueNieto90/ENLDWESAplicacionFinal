<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 07/02/2026
 * @description: Controlador para Modificar Departamento.
 */

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['codDepartamentoEnCurso'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

$codDepartamento = $_SESSION['codDepartamentoEnCurso'];
$oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($codDepartamento);

$entradaOK = true;
$aErrores = ['descDepartamento' => null, 'volumenDeNegocio' => null];

if (isset($_REQUEST['aceptar'])) {
    
    // Validaciones
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento'], 255, 4, 1);
    
    $volumenFiltrado = str_replace(',', '.', $_REQUEST['volumenDeNegocio']);
    $aErrores['volumenDeNegocio'] = validacionFormularios::comprobarFloat($volumenFiltrado, 1000000000, 0, 1);

    foreach ($aErrores as $e) {
        if ($e != null) $entradaOK = false;
    }

    if ($entradaOK) {
        if (DepartamentoPDO::modificaDepartamento($codDepartamento, $_REQUEST['descDepartamento'], (float)$volumenFiltrado)) {
            $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
            header('Location: index.php');
            exit;
        } else {
            $aErrores['descDepartamento'] = "Error al modificar.";
        }
    }
} else {
    $entradaOK = false;
}

// Datos para vista (Ojo: volumen sin formatear bonito para poder editarlo bien, ej: 1500.50 en vez de 1.500,50)
$descMostrar = isset($_REQUEST['aceptar']) ? $_REQUEST['descDepartamento'] : $oDepartamento->getDescDepartamento();
$volumenMostrar = isset($_REQUEST['aceptar']) ? $_REQUEST['volumenDeNegocio'] : $oDepartamento->getVolumenDeNegocio();

$avModificarDepartamento = [
    'codDepartamento' => $oDepartamento->getCodDepartamento(),
    'descDepartamento' => $descMostrar,
    'volumenDeNegocio' => $volumenMostrar,
    'fechaCreacion' => (new DateTime($oDepartamento->getFechaCreacionDepartamento()))->format('d/m/Y')
];
?>

