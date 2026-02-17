<?php

/**
 * @author: Enrique Nieto Lorenzo
 * @since: 21/01/2026
 * @description: Controlador para la API REST de la NASA.
 */
// BOTÓN DE VOLVER
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['verDetalleNasa'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'detalleFotoNasa';
    header('Location: index.php');
    exit;
}

// INICIALIZACIÓN DE FECHAS Y VARIABLES API NASA
$oFechaHoy = new DateTime();
$fechaHoyFormateada = $oFechaHoy->format('Y-m-d');
$fechaMinima = '1995-06-16'; // Primera foto de la NASA
// Si es la primera vez que entramos, inicializamos la fecha a HOY
if (!isset($_SESSION['fechaNasaEnCurso'])) {
    $_SESSION['fechaNasaEnCurso'] = $fechaHoyFormateada;
}

// Inicializamos array de errores y variable de control
$aErrores = ['fechaNasaEnCurso' => null];
$entradaOK = true;

// Si se ha pulsado Buscar
if (isset($_REQUEST['entrar'])) {

    // Controlamos que el usuario no ponga una fecha prohibida
    $aErrores['fechaNasaEnCurso'] = validacionFormularios::validarFecha(
                    $_REQUEST['fechaNasaEnCurso'],
                    $fechaHoyFormateada,
                    $fechaMinima,
                    1
    );

    if ($aErrores['fechaNasaEnCurso'] != null) {
        $entradaOK = false;
    }

    if ($entradaOK) {
        // Si la fecha es válida, la guardamos
        $fechaNueva = $_REQUEST['fechaNasaEnCurso'];

        // Solo llamamos a la API si la fecha ha cambiado
        if ($fechaNueva !== $_SESSION['fechaNasaEnCurso']) {
            $_SESSION['fechaNasaEnCurso'] = $fechaNueva;

            // Borramos la foto anterior para forzar la recarga en el bloque siguiente
            unset($_SESSION['fotoNasaEnCurso']);
        }
    }
}

// Recuperamos la fecha válida actual
$fechaSolicitada = $_SESSION['fechaNasaEnCurso'];
$oFotoNasa = null;

// Comprobamos si ya tenemos esa foto en sesión para no llamar a la API innecesariamente
if (isset($_SESSION['fotoNasaEnCurso']) &&
        $_SESSION['fotoNasaEnCurso'] instanceof FotoNasa &&
        $_SESSION['fotoNasaEnCurso']->getFecha() === $fechaSolicitada) {

    $oFotoNasa = $_SESSION['fotoNasaEnCurso'];
} else {
    $oFotoNasa = REST::apiNasa($fechaSolicitada);

    // Guardamos en sesión
    $_SESSION['fotoNasaEnCurso'] = $oFotoNasa;
}

// Ocultar botón detalle cuando hay error
$mostrarBotonDetalle = true;
if ($oFotoNasa->getTitulo() === 'Error de conexión con la NASA') {
    $mostrarBotonDetalle = false;
}

// API HISTORIA WIKIPEDIA
// Inicializamos con la fecha de hoy por defecto si no existe
if (!isset($_SESSION['fechaHistoriaEnCurso'])) {
    $_SESSION['fechaHistoriaEnCurso'] = $fechaHoyFormateada;
}

$aErroresHistoria = ['fechaHistoriaEnCurso' => null];
$entradaHistoriaOK = true;

// Procesamos el formulario si han pulsado el botón de buscar
if (isset($_REQUEST['buscarHistoria'])) {

    // Validamos la fecha
    $aErroresHistoria['fechaHistoriaEnCurso'] = validacionFormularios::validarFecha($_REQUEST['fechaHistoriaEnCurso'], '2100-01-01', '1000-01-01', 1);

    if ($aErroresHistoria['fechaHistoriaEnCurso'] != null) {
        $entradaHistoriaOK = false;
    }

    if ($entradaHistoriaOK) {
        $fechaNuevaHist = $_REQUEST['fechaHistoriaEnCurso'];

        // Si cambia la fecha o si queremos forzar a que busque otro evento aleatorio del mismo día
        $_SESSION['fechaHistoriaEnCurso'] = $fechaNuevaHist;
        unset($_SESSION['eventoHistoricoEnCurso']); // Destruimos sesión para recargar la nueva
    }
}

$fechaHistoriaSolicitada = $_SESSION['fechaHistoriaEnCurso'];
$oEventoHistorico = null;

// Llamada a la API
if (isset($_SESSION['eventoHistoricoEnCurso']) && $_SESSION['eventoHistoricoEnCurso'] instanceof EventoHistorico) {
    // Si ya lo tenemos en sesión, lo usamos
    $oEventoHistorico = $_SESSION['eventoHistoricoEnCurso'];
} else {
    // Sacamos el mes y el día de la fecha
    $fechaObj = DateTime::createFromFormat('Y-m-d', $fechaHistoriaSolicitada);
    $mes = $fechaObj->format('m');
    $dia = $fechaObj->format('d');

    // Llamamos a la API
    $oEventoHistorico = REST::apiWikipediaEfemerides($mes, $dia);
    $_SESSION['eventoHistoricoEnCurso'] = $oEventoHistorico;
}

// PREPARAR ARRAY PARA LA VISTA
$avRest = [
    // API Nasa
    'fechaNasaEnCurso' => $fechaSolicitada,
    'fotoNasaEnCursoTitulo' => $oFotoNasa->getTitulo(),
    'fotoNasaEnCursoUrl' => $oFotoNasa->getUrl(),
    'fotoNasaEnCursoDescripcion' => $oFotoNasa->getDescripcion(),
    'mostrarBotonDetalle' => $mostrarBotonDetalle,
    // API Wikipedia
    'fechaHistoriaEnCurso' => $fechaHistoriaSolicitada,
    'historiaAnio' => $oEventoHistorico->getAnio(),
    'historiaDescripcion' => $oEventoHistorico->getDescripcion(),
    'historiaUrl' => $oEventoHistorico->getUrlArticulo(),
    'errorHistoria' => $aErroresHistoria['fechaHistoriaEnCurso']
];
?>