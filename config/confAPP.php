<?php
/**
 * @author Enrique Nieto Lorenzo
 * @since 18/01/2026
 * @description Archivo de configuración de rutas.
 */

// CARGA DE LIBRERÍA DE VALIDACIÓN
require_once 'core/231018libreriaValidacion.php';

// CARGA DEL MODELO
require_once 'model/Usuario.php';
require_once 'model/UsuarioPDO.php';
require_once 'model/ErrorApp.php';

// Modelos de la API
require_once 'model/REST.php';
require_once 'model/FotoNasa.php';

//Constante con la APIKEY de la NASA
const API_KEY_NASA = 'VArtVZZeOSBGcSkPjTl7VzP0gX2olfPh8kdQgz3b';

// ARRAY DE CONTROLADORES
$controller = [
    'inicioPublico'    => 'controller/cInicioPublico.php',
    'login'            => 'controller/cLogin.php',
    'inicioPrivado'    => 'controller/cInicioPrivado.php',
    'detalle'          => 'controller/cDetalle.php',
    'registro'         => 'controller/cRegistro.php',
    'wip'              => 'controller/cWIP.php',
    'error'            => 'controller/cError.php',
    'rest'             => 'controller/cRest.php',
    'mtoDepartamentos' => 'controller/cMtoDepartamentos.php'
];

// ARRAY DE VISTAS
$view = [
    'layout'           => 'view/layout.php',
    'inicioPublico'    => 'view/vInicioPublico.php',
    'login'            => 'view/vLogin.php',
    'inicioPrivado'    => 'view/vInicioPrivado.php',
    'detalle'          => 'view/vDetalle.php',
    'registro'         => 'view/vRegistro.php',
    'wip'              => 'view/vWIP.php',
    'error'            => 'view/vError.php',
    'rest'             => 'view/vRest.php',
    'mtoDepartamentos' => 'view/vMtoDepartamentos.php'
];
?>