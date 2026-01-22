<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Clase REST para la gestión de la conexión con un Web Service a través de una API REST.
 */

class REST {
    /**
     * Llama a la API APOD de la NASA.
     * * @param string $fecha Fecha en formato YYYY-MM-DD
     * @return FotoNasa|null Devuelve el objeto con datos o null si falla.
     */
    public static function apiNasa($fecha) {
        
        $url = "https://api.nasa.gov/planetary/apod?date=$fecha&api_key=" . API_KEY_NASA;

        $resultado = @file_get_contents($url);

        if ($resultado !== false) {
            $archivoApi = json_decode($resultado, true);
            
            // Verificamos que no haya error en el JSON devuelto
            if (isset($archivoApi['title'])) {
                return new FotoNasa(
                    $archivoApi['title'],
                    $archivoApi['url'],
                    $archivoApi['date']
                );
            }
        }
        
        return null;
    }
}
?>