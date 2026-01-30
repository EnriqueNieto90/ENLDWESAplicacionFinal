<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Clase REST para la gestión de la conexión con la API de la NASA.
 */

class REST {

    /**
     * Llama a la API APOD de la NASA.
     * Descarga la imagen HD al servidor local y devuelve un objeto FotoNasa.
     * Si falla, devuelve un objeto FotoNasa con datos de error.
     * * @param string $sFecha Fecha en formato YYYY-MM-DD
     * @return FotoNasa Devuelve siempre un objeto FotoNasa (con datos reales o de error).
     */
    public static function apiNasa($sFecha) {
        
        $oFotoNasa = null;
        $sUrl = "https://api.nasa.gov/planetary/apod?date=$sFecha&api_key=" . API_KEY_NASA;

        // 1. Iniciamos cURL
        $oCurl = curl_init(); 

        // 2. Configuramos las opciones
        curl_setopt($oCurl, CURLOPT_URL, $sUrl);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 10);          
        
        // Configuración SSL (importante para servidores locales/NAS)
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);

        // 3. Ejecutamos la petición
        $sResultado = curl_exec($oCurl); 
        
        // 4. Control de errores de conexión (cURL)
        if (curl_errno($oCurl)) {
            curl_close($oCurl);
            $oFotoNasa = null; // Nos aseguramos de que siga siendo null
        } else {
            // Obtenemos el código HTTP antes de cerrar
            $iHttpCode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
            curl_close($oCurl);

            // Si el código no es 200 (OK), falló la API
            if ($iHttpCode !== 200) {
                $oFotoNasa = null;
            } else {
                // 5. Procesamos el JSON si la conexión fue exitosa
                $aArchivoApi = json_decode($sResultado, true);

                // Validamos que el array tenga los datos necesarios
                if (isset($aArchivoApi) && !isset($aArchivoApi['error'])) {
                    if (isset($aArchivoApi['date'], $aArchivoApi['explanation'], $aArchivoApi['title'], $aArchivoApi['url'])) {
                        
                        // Obtenemos la URL HD o usamos la normal si no existe
                        $sHdUrl = $aArchivoApi['hdurl'] ?? $aArchivoApi['url'];
                        
                        // [NUEVO] Descargamos la imagen al servidor local
                        $sRutaDestino = self::descargarImagen($sHdUrl);

                        // Creamos el objeto con la RUTA LOCAL en lugar de la URL remota
                        // Esto permite mostrar la imagen incluso si el cliente no tiene acceso a internet después
                        $oFotoNasa = new FotoNasa(
                            $aArchivoApi['date'], 
                            $aArchivoApi['explanation'], 
                            $sHdUrl, // Guardamos la URL HD original por si acaso
                            $aArchivoApi['title'], 
                            $sRutaDestino // Usamos la imagen descargada para mostrar
                        );
                    }
                }
            }
        }

        // [NUEVO] Gestión del Objeto de Error
        // Si por cualquier razón (curl, json, validación) $oFotoNasa sigue siendo null...
        if ($oFotoNasa == null) {
            $oFotoNasa = new FotoNasa(
                $sFecha, // Mantenemos la fecha solicitada
                'No se ha podido recuperar la información del servidor de la NASA. Por favor, inténtelo más tarde.',
                'webroot/media/images/banderaEs.png', // Imagen de error (Asegúrate de tener esta imagen)
                'ERROR: Foto no disponible',
                'webroot/media/images/banderaEs.png'
            );
        }

        return $oFotoNasa;
    }

}
?>