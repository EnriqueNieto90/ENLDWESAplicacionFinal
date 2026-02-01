<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 21/01/2026
 * @description: Controlador para la API REST de la NASA.
 * Gestiona la sesión para minimizar llamadas a la API.
 */

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

// 3. GESTIÓN DEL FORMULARIO (POST)
// ==========================================================
$entradaOK = true;
$aErrores = ['fechaNasaEnCurso' => null];

if (isset($_REQUEST['entrar'])) { // Botón "Buscar" de tu vista
    
    // Obtenemos fecha actual para validación
    $fechaHoy = new DateTime();
    $fechaHoyFormateada = $fechaHoy->format('Y-m-d');

    // Validación: No vacía, formato fecha, y rango (entre 1995 y hoy)
    // Nota: Ajusta validacionFormularios según tu librería (algunas piden d/m/Y otras Y-m-d)
    $aErrores['fechaNasaEnCurso'] = validacionFormularios::validarFecha(
        $_REQUEST['fechaNasaEnCurso'], 
        $fechaHoyFormateada, 
        '1995-06-16', 
        1
    );

    if ($aErrores['fechaNasaEnCurso'] != null) {
        $entradaOK = false;
    }

    if ($entradaOK) {
        // SI ES VÁLIDO:
        // 1. Guardamos la fecha deseada en sesión.
        $_SESSION['fechaNasaEnCurso'] = $_REQUEST['fechaNasaEnCurso'];
        
        // 2. IMPORTANTE: Borramos la foto anterior de la sesión.
        // Al borrarla, forzamos a que en la recarga (GET) se baje la nueva.
        unset($_SESSION['fotoNasaEnCurso']);

        // 3. Recargamos la página (Patrón PRG) para evitar reenvíos de formulario.
        header('Location: index.php');
        exit;
    }
}

// 4. LÓGICA DE RECUPERACIÓN DE DATOS (GET)
// ==========================================================

// A. Determinar la Fecha:
// Si no hay fecha en sesión (primera vez que entra), usamos HOY.
if (!isset($_SESSION['fechaNasaEnCurso'])) {
    $fechaHoy = new DateTime();
    $_SESSION['fechaNasaEnCurso'] = $fechaHoy->format('Y-m-d');
}
$fechaSolicitada = $_SESSION['fechaNasaEnCurso'];


// B. Determinar el Objeto Foto (Sistema de Caché):
$oFotoNasa = null;

// ¿Tenemos una foto guardada en sesión Y coincide con la fecha que queremos ver?
if (isset($_SESSION['fotoNasaEnCurso']) && 
    $_SESSION['fotoNasaEnCurso']->getFecha() === $fechaSolicitada) {
    
    // Si coincide, la usamos (Ahorramos llamada a la API)
    $oFotoNasa = $_SESSION['fotoNasaEnCurso'];

} else {
    // Si no existe o la fecha es distinta, llamamos a la API
    // Tu clase REST ya se encarga de devolver un objeto válido (con datos o con error)
    $oFotoNasa = REST::apiNasa($fechaSolicitada);
    
    // Guardamos el resultado en sesión para la próxima vez
    $_SESSION['fotoNasaEnCurso'] = $oFotoNasa;
}


// 5. PREPARAR ARRAY PARA LA VISTA
// ==========================================================
$avRest = [
    'fechaNasaEnCurso'           => $fechaSolicitada,
    'fotoNasaEnCursoTitulo'      => $oFotoNasa->getTitulo(),
    'fotoNasaEnCursoUrl'         => $oFotoNasa->getUrl(),
    'fotoNasaEnCursoUrlHD'       => $oFotoNasa->getUrlHD(),
    'fotoNasaEnCursoDescripcion' => $oFotoNasa->getDescripcion()
];
?>