<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 17/02/2026
 * @description: Configuración de seguridad y credenciales para las APIs REST.
 */

const CLAVES_API_PERMITIDAS = [
    'xK9pQ2mW5vY8nZ4cT1bH7jL0dF3gR6sN',  // Clave principal para la app web
    'dev_9Xp2_K7mF_4vLw' // Clave secundaria para otro dispositivo
];

// Cabeceras CORS y JSON
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
// Permitimos a JavaScript enviar la cabecera personalizada de la clave
header("Access-Control-Allow-Headers: Content-Type, x-api-key"); 

// Declaramos de forma explícita los métodos que aceptamos
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Si el navegador envía la petición OPTIONS le decimos que OK.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Usamos getallheaders() para evitar que configuraciones estrictas de Apache oculten $_SERVER
$keyRecibida = '';
$cabeceras = getallheaders();

// Recorremos las cabeceras forzándolas a minúsculas para evitar fallos si el servidor cambia X-API-KEY por x-api-key
foreach ($cabeceras as $nombre => $valor) {
    if (strtolower($nombre) === 'x-api-key') {
        $keyRecibida = trim($valor);
        break;
    }
}

// En el caso de que el servidor no soporta getallheaders()
if (empty($keyRecibida)) {
    $keyRecibida = trim($_SERVER['HTTP_X_API_KEY'] ?? '');
}

if (!in_array($keyRecibida, CLAVES_API_PERMITIDAS)) {
    // Si la clave no está en la lista, devolvemos error 401 (No Autorizado) y salimos del proceso.
    http_response_code(401);

    echo json_encode([]);
    exit; 
}
?>
