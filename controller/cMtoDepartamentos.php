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

// BAJA LÓGICA
if (isset($_REQUEST['baja'])) {
    // Llamamos al modelo para poner fecha de baja como now()
    if (DepartamentoPDO::bajaLogicaDepartamento($_REQUEST['codDepartamento'])) {
        // Recargamos para que la tabla se pinte de rojo
        header('Location: index.php');
        exit;
    }
}

// ALTA LÓGICA
if (isset($_REQUEST['alta'])) {
    // Llamamos al modelo para poner fecha de baja a null
    if (DepartamentoPDO::altaLogicaDepartamento($_REQUEST['codDepartamento'])) {
        // Recargamos para que la tabla vuelva a estar normal
        header('Location: index.php');
        exit;
    }
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

if (isset($_REQUEST['borrar'])) {
    // Guardamos el código
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['codDepartamento'];
    $_SESSION['paginaEnCurso'] = 'eliminarDepartamento';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['anadir'])) {
    // Guardamos el código
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['codDepartamento'];
    $_SESSION['paginaEnCurso'] = 'altaDepartamento';
    header('Location: index.php');
    exit;
}

// EXPORTAR DEPARTAMENTOS A JSON
if (isset($_REQUEST['exportar'])) {

    // Pedimos al modelo el array listo para exportar
    $sBusquedaActual = $_SESSION['busquedaDptoEnCurso'] ?? '';
    $aDatosExportar = DepartamentoPDO::exportarDepartamentos($sBusquedaActual);

    // Codificamos a JSON
    $sJson = json_encode($aDatosExportar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // Forzamos la descarga en el navegador con un nombre único basado en la fecha y hora
    $sNombreArchivo = "Departamentos_" . date('Ymd_His') . ".json";
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $sNombreArchivo . '"');

    // Imprimimos el JSON
    echo $sJson;
    exit;
}

// IMPORTAR DEPARTAMENTOS DESDE JSON
$sMensajeImportacion = ""; // Para mostrar en la vista
$sErrorImportacion = "";

if (isset($_REQUEST['importar'])) {

    if (isset($_FILES['archivoImportacion']) && $_FILES['archivoImportacion']['error'] === UPLOAD_ERR_OK) {

        $sContenidoArchivo = file_get_contents($_FILES['archivoImportacion']['tmp_name']);
        $aDatosJSON = json_decode($sContenidoArchivo, true);

        // Validamos que el archivo es un JSON bien formado
        if (json_last_error() === JSON_ERROR_NONE && is_array($aDatosJSON)) {

            // Llamamos a nuestro modelo para importar
            if (DepartamentoPDO::importarDepartamentos($aDatosJSON)) {
                $sMensajeImportacion = "¡Se han importado " . count($aDatosJSON) . " departamentos correctamente!";
            } else {
                $sErrorImportacion = "Error en la importación. Es posible que haya códigos duplicados o datos inválidos. Operación cancelada.";
            }
        } else {
            $sErrorImportacion = "El archivo subido no tiene un formato JSON válido.";
        }
    } else {
        $sErrorImportacion = "No se ha podido subir el archivo o no has seleccionado ninguno.";
    }
}

// GESTIÓN DE FILTROS Y PAGINACIÓN
// Recuperar filtros de la sesión o inicializar por defecto
$descripcionBuscada = $_SESSION['criterioBusqueda']['desc'] ?? "";
$estadoBuscado = $_SESSION['criterioBusqueda']['estado'] ?? "alta";

// Si el usuario pulsa BUSCAR, actualizamos la sesión y reiniciamos a página 1
if (isset($_REQUEST['buscar'])) {
    $descripcionBuscada = $_REQUEST['descDepartamento'] ?? "";
    $estadoBuscado = $_REQUEST['estado'] ?? "alta";

    $_SESSION['criterioBusqueda']['desc'] = $descripcionBuscada;
    $_SESSION['criterioBusqueda']['estado'] = $estadoBuscado;
    $_SESSION['paginaActual'] = 1; // Al buscar, volvemos al principio
}

// Gestión de botones de PAGINACIÓN
$paginaActual = $_SESSION['paginaActual'] ?? 1;

// Contamos el total de registros para saber la última página
$totalRegistros = DepartamentoPDO::contarDepartamentosPorDescEstado($descripcionBuscada, $estadoBuscado);
$totalPaginas = ceil($totalRegistros / RESULTADOS_POR_PAGINA);

// Asegurar que al menos hay 1 página
if ($totalPaginas < 1)
    $totalPaginas = 1;

// Lógica de navegación
if (isset($_REQUEST['paginaPrimera'])) {
    $paginaActual = 1;
}
if (isset($_REQUEST['paginaAnterior']) && $paginaActual > 1) {
    $paginaActual--;
}
if (isset($_REQUEST['paginaSiguiente']) && $paginaActual < $totalPaginas) {
    $paginaActual++;
}
if (isset($_REQUEST['paginaUltima'])) {
    $paginaActual = $totalPaginas;
}

// Guardamos la página actual en sesión
$_SESSION['paginaActual'] = $paginaActual;

// Recuperar los datos de la DB usando el método PAGINADO
$aDepartamentosEncontrados = DepartamentoPDO::buscaDepartamentosPorDescEstadoPaginado(
                $descripcionBuscada,
                $estadoBuscado,
                $paginaActual
);

// PREPARAR ARRAY PARA LA VISTA
$avMtoDepartamentos = [];

if ($aDepartamentosEncontrados) {
    foreach ($aDepartamentosEncontrados as $oDep) {
        $avMtoDepartamentos[] = [
            'cod' => $oDep->getCodDepartamento(),
            'desc' => $oDep->getDescDepartamento(),
            'volumen' => number_format($oDep->getVolumenDeNegocio(), 2, ',', '.') . ' €',
            'fechaAlta' => (new DateTime($oDep->getFechaCreacionDepartamento()))->format('d/m/Y'),
            'fechaBaja' => $oDep->getFechaBajaDepartamento() ? (new DateTime($oDep->getFechaBajaDepartamento()))->format('d/m/Y') : '-',
            // Añadimos clase CSS para pintar rojo si está de baja
            'estilo' => $oDep->getFechaBajaDepartamento() ? 'fila-baja' : ''
        ];
    }
}

// Pasamos variables extra a la vista para pintar la paginación
$valorDescBuscar = $descripcionBuscada;
$valorEstadoBuscar = $estadoBuscado;
?>
