<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Clase REST para la gestión de la conexión con la API de la NASA.
 */
class REST {

    /**
     * Llama a la API APOD de la NASA.
     * Devuelve SIEMPRE un objeto FotoNasa (con datos reales o de error).
     */
    public static function apiNasa($sFecha) {
        $sUrl = "https://api.nasa.gov/planetary/apod?date=$sFecha&api_key=" . API_KEY_NASA;

        // Configuración básica de cURL
        $oCurl = curl_init(); 
        curl_setopt($oCurl, CURLOPT_URL, $sUrl);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 5); 
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);

        $sResultado = curl_exec($oCurl); 
        $iHttpCode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        $bErrorCurl = curl_errno($oCurl);
        curl_close($oCurl);

        // Si la conexión es exitosa
        if (!$bErrorCurl && $iHttpCode === 200) {
            $aArchivoApi = json_decode($sResultado, true);

            if (isset($aArchivoApi['title'], $aArchivoApi['url'])) {
                $sUrlNormal = $aArchivoApi['url'];
                $sUrlHD = $aArchivoApi['hdurl'] ?? $sUrlNormal;

                return new FotoNasa(
                    $aArchivoApi['title'], 
                    $sUrlNormal,        
                    $aArchivoApi['date'] ?? $sFecha,
                    $aArchivoApi['explanation'] ?? 'Sin descripción disponible.',
                    $sUrlHD             
                );
            }
        }

        // Si la consulta a la API devuelve algo que no podemos controlar se lanza un objeto de error
        return new FotoNasa(
            'Error de conexión con la NASA',
            'webroot/images/error_nasa.jpg',
            $sFecha,
            'No disponible',
            'webroot/images/error_nasa.jpg'
        );
    }
}
?>