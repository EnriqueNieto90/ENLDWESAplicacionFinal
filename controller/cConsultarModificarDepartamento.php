<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 30/01/2026
 * @description: Controlador para Consultar y Modificar un Departamento.
 */

// Control de botón Volver
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

// Control del botón CANCELAR (Volver atrás sin guardar)
if (isset($_REQUEST['cancelar'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

// Recuperar el objeto departamento que vamos a editar
// Usamos el código guardado en la sesión desde la vista anterior
if (!isset($_SESSION['codDepartamentoEnCurso'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

$codDepartamento = $_SESSION['codDepartamentoEnCurso'];
$oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($codDepartamento);

// Inicialización de variables y errores
$entradaOK = true;
$aErrores = [
    'descDepartamento' => null,
    'volumenDeNegocio' => null
];

// Procesar formulario si se pulsa ACEPTAR
if (isset($_REQUEST['aceptar'])) {
    
    // Validación: Descripción (Alfabético, obligatorio)
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descDepartamento'], 255, 1, 1);
    
    // Validación: Volumen de Negocio (Float, sustituimos coma por punto primero)
    $volumenFiltrado = str_replace(',', '.', $_REQUEST['volumenDeNegocio']);
    $aErrores['volumenDeNegocio'] = validacionFormularios::comprobarFloat($volumenFiltrado, 1000000000, 0, 1);

    // Comprobar si hay errores
    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    // SI TODO ESTÁ CORRECTO: Modificamos en BBDD
    if ($entradaOK) {
        $descNueva = $_REQUEST['descDepartamento'];
        $volumenNuevo = (float) $volumenFiltrado;

        // Llamamos al método modificar de tu PDO
        if (DepartamentoPDO::modificaDepartamento($codDepartamento, $descNueva, $volumenNuevo)) {
            // Si sale bien, volvemos al mantenimiento
            $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
            header('Location: index.php');
            exit;
        } else {
            // Error en BBDD
            $aErrores['descDepartamento'] = "Error al modificar en la base de datos.";
        }
    }
} else {
    $entradaOK = false;
}

// Preparar datos para la Vista
// Si venimos de un error de validación, mostramos lo que escribió el usuario ($_REQUEST)
// Si cargamos la página por primera vez, mostramos los datos del objeto ($oDepartamento)

$descMostrar = isset($_REQUEST['aceptar']) ? $_REQUEST['descDepartamento'] : $oDepartamento->getDescDepartamento();
$volumenMostrar = isset($_REQUEST['aceptar']) ? $_REQUEST['volumenDeNegocio'] : $oDepartamento->getVolumenDeNegocio();

// Formateo de fechas para la vista
$fechaAlta = new DateTime($oDepartamento->getFechaCreacionDepartamento());
$fechaBaja = $oDepartamento->getFechaBajaDepartamento();
$fechaBajaStr = ($fechaBaja) ? (new DateTime($fechaBaja))->format('d/m/Y') : '-';

$avDepartamento = [
    'codDepartamento' => $oDepartamento->getCodDepartamento(),
    'descDepartamento' => $descMostrar,
    'fechaCreacion' => $fechaAlta->format('d/m/Y'),
    'volumenDeNegocio' => $volumenMostrar,
    'fechaBaja' => $fechaBajaStr
];
?>

