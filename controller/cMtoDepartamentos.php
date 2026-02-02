<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 27/01/2026
 * @description: Controlador de Mantenimiento de Departamentos.
 */

// Control de botón Volver
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['editar'])) {
    // Guardamos el código del departamento seleccionado en la sesión
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['codDepartamento'];
    $_SESSION['paginaEnCurso'] = 'modificarDepartamento';  
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['ver'])) {
    // Guardamos el código
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['codDepartamento'];
    $_SESSION['paginaEnCurso'] = 'consultarDepartamento';
    
    header('Location: index.php');
    exit;
}

// Definimos el valor por defecto recuperando de la sesión (si existe) o cadena vacía
$descripcionBuscada = $_SESSION['descripcionBuscadaEnCurso'] ?? "";

// Si el usuario ha enviado una nueva búsqueda, sobrescribimos la variable y actualizamos la sesión
if (isset($_REQUEST['buscar'])) {
    $descripcionBuscada = $_REQUEST['descDepartamento'] ?? "";
    $_SESSION['descripcionBuscadaEnCurso'] = $descripcionBuscada;
}

// Recuperar los datos de la DB
$aDepartamentosEncontrados = DepartamentoPDO::buscaDepartamentosPorDesc($descripcionBuscada);

// PREPARAR ARRAY PARA LA VISTA
$aVistaDepartamentos = [];

if ($aDepartamentosEncontrados) {
    foreach ($aDepartamentosEncontrados as $oDep) {
        $aVistaDepartamentos[] = [
            'cod' => $oDep->getCodDepartamento(),
            'desc' => $oDep->getDescDepartamento(),
            'volumen' => number_format($oDep->getVolumenDeNegocio(), 2, ',', '.') . ' €',
            'fechaAlta' => (new DateTime($oDep->getFechaCreacionDepartamento()))->format('d/m/Y'),
            'fechaBaja' => $oDep->getFechaBajaDepartamento() ? (new DateTime($oDep->getFechaBajaDepartamento()))->format('d/m/Y') : '-'
        ];
    }
}

// Guardamos el término buscado para que se mantenga en el input
$valorBuscar = $descripcionBuscada;
?>
