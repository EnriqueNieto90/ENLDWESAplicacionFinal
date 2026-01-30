<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 27/01/2026
 * @description: Controlador de Mantenimiento de Departamentos.
 */

// Si no hay usuario logueado, mandar al login
if (!isset($_SESSION['usuarioENLAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'login';
    header('Location: index.php');
    exit;
}

// BOTÓN CERRAR SESIÓN
if (isset($_REQUEST['cerrarSesion'])) {
    session_destroy();
    session_start();
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// Control de botón Volver
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['editar'])) {
    // Guardamos el código del departamento seleccionado en la sesión
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['codDepartamento'];
    
    // Cambiamos la página actual para que index.php cargue el controlador de edición
    $_SESSION['paginaEnCurso'] = 'editarDepartamento'; 
    
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['ver'])) {
    // Guardamos el código
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['codDepartamento'];
    
    // Cambiamos la página a modo consulta (esto activará los 'disabled' en la vista de destino)
    $_SESSION['paginaEnCurso'] = 'consultarDepartamento';
    
    header('Location: index.php');
    exit;
}

// Por defecto buscamos todo
$descripcionBuscada = "";

if (isset($_SESSION["descripcionBuscadaEnCurso"])) {
    $descripcionBuscada = $_SESSION["descripcionBuscadaEnCurso"];
}

// Si se ha pulsado buscar y hay texto
if (isset($_REQUEST['buscar'])) {
    $descripcionBuscada = $_REQUEST['descDepartamento'] ?? "";
    $_SESSION['descripcionBuscadaEnCurso'] = $descripcionBuscada;
}
//Si NO ha pulsado buscar, miramos si tenía algo guardado de antes
elseif (isset($_SESSION['descripcionBuscadaEnCurso'])) {
    $descripcionBuscada = $_SESSION['descripcionBuscadaEnCurso'];
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
