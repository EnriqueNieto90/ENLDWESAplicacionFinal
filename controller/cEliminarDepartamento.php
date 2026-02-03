<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 03/02/2026
 * @description: Controlador para eliminar un departamento (Baja Física).
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

// Si le das a botón eliminar o aceptar
if (isset($_REQUEST['eliminar'])) {
    if (DepartamentoPDO::bajaFisicaDepartamento($_SESSION['codDepartamentoEnCurso'])) {
        $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
        header('Location: index.php');
        exit;
    } else {
        // Manejar error si no se puede borrar
        $error = "No se ha podido eliminar el departamento.";
    }
}

// Recuperar datos para mostrar lo que vas a borrar
$oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($_SESSION['codDepartamentoEnCurso']);

// Formateo de fechas y números para la vista
$fechaBaja = $oDepartamento->getFechaBajaDepartamento();
$fechaBajaStr = ($fechaBaja) ? (new DateTime($fechaBaja))->format('d/m/Y') : '-';

$avEliminarDepartamento = [
    'codDepartamento' => $oDepartamento->getCodDepartamento(),
    'descDepartamento' => $oDepartamento->getDescDepartamento(),
    'fechaCreacion' => (new DateTime($oDepartamento->getFechaCreacionDepartamento()))->format('d/m/Y'),
    'volumenNegocio' => number_format($oDepartamento->getVolumenDeNegocio(), 2, ',', '.') . ' €',
    'fechaBaja' => $fechaBajaStr
];
?>
