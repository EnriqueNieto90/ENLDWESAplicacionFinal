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

// ARRAY DE CONTROLADORES
$controller = [
    'inicioPublico' => 'controller/cInicioPublico.php',
    'login'         => 'controller/cLogin.php',
    'inicioPrivado' => 'controller/cInicioPrivado.php',
    'detalle'       => 'controller/cDetalle.php',
    'registro'      => 'controller/cRegistro.php',
    'wip'           => 'controller/cWIP.php'
];

// ARRAY DE VISTAS
$view = [
    'layout'        => 'view/layout.php',
    'inicioPublico' => 'view/vInicioPublico.php',
    'login'         => 'view/vLogin.php',
    'inicioPrivado' => 'view/vInicioPrivado.php',
    'detalle'       => 'view/vDetalle.php',
    'registro'      => 'view/vRegistro.php',
    'wip'           => 'view/vWIP.php'
];
?>