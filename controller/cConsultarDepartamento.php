<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 07/02/2026
 * @description: Controlador para Consultar un Departamento.
 */

// Botón VOLVER
if (isset($_REQUEST['volver'])) {
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

// Recuperar datos
$oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($_SESSION['codDepartamentoEnCurso']);

// Formateo fechas
$fechaAlta = new DateTime($oDepartamento->getFechaCreacionDepartamento());
$fechaBaja = $oDepartamento->getFechaBajaDepartamento();
$fechaBajaStr = ($fechaBaja) ? (new DateTime($fechaBaja))->format('d/m/Y') : '-';

// Array para la vista
$avConsultarDepartamento = [
    'codDepartamento' => $oDepartamento->getCodDepartamento(),
    'descDepartamento' => $oDepartamento->getDescDepartamento(),
    'fechaCreacion' => $fechaAlta->format('d/m/Y'),
    'volumenDeNegocio' => number_format($oDepartamento->getVolumenDeNegocio(), 2, ',', '.'), // Formateado bonito para leer
    'fechaBaja' => $fechaBajaStr
];
?>

