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
require_once 'model/DBPDO.php';
require_once 'model/Departamento.php';
require_once 'model/DepartamentoPDO.php';

require_once 'model/ErrorApp.php';

// Modelos de la API
require_once 'model/REST.php';
require_once 'model/FotoNasa.php';
require_once 'model/EventoHistorico.php';

//Constante con la APIKEY de la NASA
const API_KEY_NASA = 'VArtVZZeOSBGcSkPjTl7VzP0gX2olfPh8kdQgz3b';

// Constante con la API KEY de nuestra propia API
const API_KEY_PROPIA = 'xK9pQ2mW5vY8nZ4cT1bH7jL0dF3gR6sN';

//Constante con la palabra de seguridad de la aplicación
const PALABRA_SEGURIDAD = 'pimentel';

// Constante para paginación
const RESULTADOS_POR_PAGINA = 5;

// ARRAY DE CONTROLADORES
$controller = [
    'inicioPublico'         => 'controller/cInicioPublico.php',
    'login'                 => 'controller/cLogin.php',
    'inicioPrivado'         => 'controller/cInicioPrivado.php',
    'detalle'               => 'controller/cDetalle.php',
    'detalleFotoNasa'       => 'controller/cDetalleFotoNasa.php',
    'registro'              => 'controller/cRegistro.php',
    'wip'                   => 'controller/cWIP.php',
    'error'                 => 'controller/cError.php',
    'cuenta'                => 'controller/cMiCuenta.php',
    'cambiarPassword'       => 'controller/cCambiarPassword.php',
    'borrarCuenta'          => 'controller/cBorrarCuenta.php',
    'rest'                  => 'controller/cRest.php',
    'mtoDepartamentos'      => 'controller/cMtoDepartamentos.php',
    'altaDepartamento'      => 'controller/cAltaDepartamento.php',
    'modificarDepartamento' => 'controller/cModificarDepartamento.php',
    'consultarDepartamento' => 'controller/cConsultarDepartamento.php',
    'eliminarDepartamento'  => 'controller/cEliminarDepartamento.php',
    'mtoUsuarios'           => 'controller/cMtoUsuarios.php'
];

// ARRAY DE VISTAS
$view = [
    'layout'                => 'view/layout.php',
    'inicioPublico'         => 'view/vInicioPublico.php',
    'login'                 => 'view/vLogin.php',
    'inicioPrivado'         => 'view/vInicioPrivado.php',
    'detalle'               => 'view/vDetalle.php',
    'detalleFotoNasa'       => 'view/vDetalleFotoNasa.php',
    'registro'              => 'view/vRegistro.php',
    'wip'                   => 'view/vWIP.php',
    'error'                 => 'view/vError.php',
    'cuenta'                => 'view/vMiCuenta.php',
    'cambiarPassword'       => 'view/vCambiarPassword.php',
    'borrarCuenta'          => 'view/vBorrarCuenta.php',
    'rest'                  => 'view/vRest.php',
    'mtoDepartamentos'      => 'view/vMtoDepartamentos.php',
    'altaDepartamento'      => 'view/vAltaDepartamento.php',
    'modificarDepartamento' => 'view/vModificarDepartamento.php',
    'consultarDepartamento' => 'view/vConsultarDepartamento.php',
    'eliminarDepartamento'  => 'view/vEliminarDepartamento.php',
    'mtoUsuarios'           => 'view/vMtoUsuarios.php'
];

// ARRAY DE TÍTULOS DEL HEADER
$titulos = [
    'inicioPublico'         => 'Bienvenido a la Aplicación Final',
    'login'                 => 'Login',
    'registro'              => 'Registro de Usuario',
    'inicioPrivado'         => 'Inicio Privado',
    'rest'                  => 'Servicios REST',
    'detalle'               => 'Detalles',
    'detalleFotoNasa'       => 'Detalle Imagen HD - NASA',
    'cuenta'                => 'Mi Cuenta',
    'cambiarPassword'       => 'Cambiar Contraseña',
    'borrarCuenta'          => 'Eliminar Cuenta Definitivamente',
    'wip'                   => 'En Construcción',
    'error'                 => 'Error de Aplicación',
    'mtoDepartamentos'      => 'Mantenimiento de Departamentos',
    'altaDepartamento'      => 'Añadir Departamento',
    'modificarDepartamento' => 'Editar Departamento',
    'consultarDepartamento' => 'Consultar Departamento',
    'eliminarDepartamento'  => 'Eliminar Departamento',
    'mtoUsuarios'           => 'Mantenimiento de Usuarios'
];

// ARRAY DE CONTROL DE ACCESO SEGÚN PERFIL
$controlAcceso = [
    'inicioPrivado'    => ['administrador', 'usuario'],
    'detalle'          => ['administrador', 'usuario'],
    'cuenta'           => ['administrador', 'usuario'],
    'rest'             => ['administrador', 'usuario'],
    'mtoDepartamentos' => ['administrador', 'usuario'], 
    'mtoUsuarios'      => ['administrador'], 
    'wip'              => ['administrador']
];

//ARRAY PARA DEFINIR VISTAS PÚBLICAS
$aPaginasPublicas = ['inicioPublico', 'login', 'registro', 'wip', 'error'];

// ARRAY VISTAS QUE NO LLEVAN BOTÓN VOLVER
$aVistasSinBotonVolver = ['inicioPrivado', 'login', 'inicioPublico', 'registro'];
?>

