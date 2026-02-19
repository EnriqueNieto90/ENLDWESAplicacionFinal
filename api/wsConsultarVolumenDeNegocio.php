<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 17/02/2026
 * @description: Web Service para consultar el volumen de negocio de un departamento.
 */

// Se encarga del CORS, JSON y la seguridad.
require_once 'confAPI.php';

// CARGA DE LIBRERÍA DE VALIDACIÓN
require_once '../core/231018libreriaValidacion.php';

// CARGA DEL MODELO DE DEPARTAMENTOS
require_once '../config/confDBPDO.php';
require_once '../model/Departamento.php';
require_once '../model/DepartamentoPDO.php';
require_once '../model/DBPDO.php';

$bEntradaOK = true;
// Inicializamos el array de respuesta
$aRespuesta = [];

// Comprobamos que llega el parámetro correcto
if (isset($_REQUEST['codDepartamento'])) {
    
    // Validamos que sea un código alfabético de 3 caracteres
    if (validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], 3, 3, 1)) {
        $bEntradaOK = false;
        $aRespuesta['mensaje'] = 'Código de departamento no válido.';
    }
} else {
    $bEntradaOK = false;
    $aRespuesta['mensaje'] = 'El código de departamento es obligatorio.';
}

if ($bEntradaOK) {
    // Lo pasamos a mayúsculas por seguridad antes de buscar en la base de datos
    $codDepartamento = strtoupper($_REQUEST['codDepartamento']);

    // Intentamos recuperar el objeto Departamento de la DB
    $oDepartamento = DepartamentoPDO::buscaDepartamentoPorCod($codDepartamento);

    if ($oDepartamento) {
        // Si el departamento existe, guardamos el volumen de negocio en la respuesta.
        $aRespuesta['volumenDeNegocio'] = $oDepartamento->getVolumenDeNegocio();
        $aRespuesta['exito'] = true;
    } else {
        $aRespuesta['mensaje'] = 'El departamento no existe.';
        $aRespuesta['exito'] = false;
    }
}

// Salida final
echo json_encode($aRespuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
