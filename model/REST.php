<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 02/02/2026
 * @description: Clase REST. Gestiona la comunicación externa (API y Descarga de imágenes).
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

        if ($sResultado && $iHttpCode === 200) {
            $aArchivoApi = json_decode($sResultado, true);

            if (isset($aArchivoApi['title'], $aArchivoApi['url'])) {
                
                $sUrlFoto = $aArchivoApi['url'];
                // Si es imagen, pedimos al método privado que la transforme
                if (isset($aArchivoApi['media_type']) && $aArchivoApi['media_type'] === 'image') {
                    
                    // Llamamos al método privado para serializar la imagen
                    $sBase64 = self::descargarImagenBase64($sUrlFoto);
                    
                    if ($sBase64) {
                        $sUrlFoto = $sBase64;
                    }
                }

                return new FotoNasa(
                    $aArchivoApi['title'], 
                    $sUrlFoto, 
                    $aArchivoApi['date'] ?? $sFecha,
                    $aArchivoApi['explanation'] ?? '',
                    $aArchivoApi['hdurl'] ?? ''
                );
            }
        }

        // Si la consulta a la API devuelve algo que no podemos controlar se lanza un objeto de error
        return new FotoNasa(
            'Error de conexión con la NASA',
            'webroot/media/images/error_nasa.jpg',
            $sFecha,
            'No disponible',
            'webroot/media/images/error_nasa.jpg'
        );
    }

    /**
     * Método privado para serializar la imagen de la NASA
     * Se encarga exclusivamente de la lógica técnica de bajar y convertir la imagen.
     * Al ser privado, nadie fuera de esta clase puede usarlo, manteniendo el encapsulamiento.
     */
    private static function descargarImagenBase64($sUrl) {
        if (empty($sUrl)) return null;

        $oCurlImg = curl_init($sUrl);
        curl_setopt($oCurlImg, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurlImg, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($oCurlImg, CURLOPT_TIMEOUT, 10);
        
        $sImagenBinaria = curl_exec($oCurlImg);
        $iHttpCode = curl_getinfo($oCurlImg, CURLINFO_HTTP_CODE);
        $sType = curl_getinfo($oCurlImg, CURLINFO_CONTENT_TYPE);
        curl_close($oCurlImg);

        if ($iHttpCode === 200 && $sImagenBinaria) {
            return "data:$sType;base64," . base64_encode($sImagenBinaria);
        }

        return null;
    }
    
    /**
     * Llama a la API de Wikipedia "Un día como hoy" (Efemérides).
     * @param string $sMes Mes en formato 'MM'
     * @param string $sDia Día en formato 'DD'
     * @return EventoHistorico
     */
    public static function apiWikipediaEfemerides($sMes, $sDia) {
        // url de Wikipedia en español
        $sUrl = "https://es.wikipedia.org/api/rest_v1/feed/onthisday/events/$sMes/$sDia";

        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_URL, $sUrl);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 10);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
        
        // Wikipedia exige un User-Agent o te devuelven error 403
        curl_setopt($oCurl, CURLOPT_USERAGENT, 'AppEducativaDWES/1.0 (tu@email.com)');

        $sResultado = curl_exec($oCurl);
        $iHttpCode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        curl_close($oCurl);

        if ($sResultado && $iHttpCode === 200) {
            $aArchivoApi = json_decode($sResultado, true);

            // Verificamos que vengan eventos
            if (isset($aArchivoApi['events']) && count($aArchivoApi['events']) > 0) {
                
                // La API devuelve varios eventos para un día, cogemos uno aleatorio.
                $eventoAleatorio = $aArchivoApi['events'][array_rand($aArchivoApi['events'])];
                
                // Extraemos los datos
                $anio = $eventoAleatorio['year'] ?? 'Año desconocido';
                $descripcion = $eventoAleatorio['text'] ?? 'Sin descripción disponible.';
                
                // Cogemos la URL del artículo principal relacionado
                $urlArticulo = '#';
                if (isset($eventoAleatorio['pages'][0]['content_urls']['desktop']['page'])) {
                    $urlArticulo = $eventoAleatorio['pages'][0]['content_urls']['desktop']['page'];
                }

                return new EventoHistorico($anio, $descripcion, $urlArticulo);
            }
        }

        // Si falla la API o no hay eventos, devolvemos el objeto de error
        return new EventoHistorico(
            'Error', 
            'No se ha podido conectar con Wikipedia o no hay eventos para este día.', 
            '#'
        );
    }
}
?>