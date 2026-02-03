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

// INICIALIZACIÓN DE FECHAS Y VARIABLES
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

// PREPARAR ARRAY PARA LA VISTA
$avRest = [
    'fechaNasaEnCurso'           => $fechaSolicitada,
    'fotoNasaEnCursoTitulo'      => $oFotoNasa->getTitulo(),
    'fotoNasaEnCursoUrl'         => $oFotoNasa->getUrl(),
    'fotoNasaEnCursoDescripcion' => $oFotoNasa->getDescripcion(),
    'mostrarBotonDetalle'        => $mostrarBotonDetalle
];

?>