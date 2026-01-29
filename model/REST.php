<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Clase REST para la gestión de la conexión con un Web Service a través de una API REST.
 */

class REST {
    /**
     * Llama a la API APOD de la NASA usando cURL para mayor control y seguridad.
     * * @param string $sFecha Fecha en formato YYYY-MM-DD
     * @return FotoNasa|null Devuelve el objeto con datos o null si falla.
     */
    public static function apiNasa($sFecha) {
        
        $oFotoNasa = null;
        $sUrl = "https://api.nasa.gov/planetary/apod?date=$sFecha&api_key=" . API_KEY_NASA;

        // Iniciar cURL
        $oCurl = curl_init(); 

        // Configurar las opciones de cURL
        curl_setopt($oCurl, CURLOPT_URL, $sUrl);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true); // El resultado devuelto es un string
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 10);          // Timeout de 10 segundos
        
        // Configuración SSL para entornos locales o servidores sin certificados actualizados
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);

        // Ejecutar la petición y la API devuelve un JSON (string)
        $sResultado = curl_exec($oCurl); 
        
        // Controlar los errores de conexión de cURL
        if (curl_errno($oCurl)) {
            curl_close($oCurl);
            return null;
        }

        // Devuelve un código HTTP
        $iHttpCode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        curl_close($oCurl);

        // Si el código no es 200 (OK), algo ha ido mal
        if ($iHttpCode !== 200) {
            return null;
        }

        // Decodificamos o deseralizamos el JSON en un array asociativo
        $aArchivoApi = json_decode($sResultado, true);

        // Validamos que el array y sus claves existan
        if (isset($aArchivoApi) && !isset($aArchivoApi['error'])) {
            if (isset($aArchivoApi['date'], $aArchivoApi['explanation'], $aArchivoApi['title'], $aArchivoApi['url'])) {
                
                // Almacenar la url en HD o en su defecto hacerlo con la url normal
                $sHdUrl = $aArchivoApi['hdurl'] ?? $aArchivoApi['url'];
                
                // Instanciamos el objeto con los datos del array
                $oFotoNasa = new FotoNasa(
                    $aArchivoApi['date'], 
                    $aArchivoApi['explanation'], 
                    $sHdUrl, 
                    $aArchivoApi['title'], 
                    $aArchivoApi['url']
                );
            }
        }

        return $oFotoNasa;
    }
}
?>