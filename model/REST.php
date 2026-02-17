<?php

/**
 * Clase REST.
 * * Gestiona la comunicación externa mediante peticiones HTTP (cURL).
 * Se encarga de consumir APIs de terceros (NASA, Wikipedia) y la propia API interna 
 * de la aplicación, decodificando las respuestas JSON e instanciando los objetos necesarios.
 *
 * @author Enrique Nieto Lorenzo
 * @since 02/02/2026
 * @version 1.2.0
 */
class REST {

    /**
     * Consume la API APOD (Astronomy Picture of the Day) de la NASA.
     * * Realiza una petición cURL utilizando la API Key definida en configuración.
     * Si la respuesta es exitosa y es una imagen, descarga y codifica la imagen en Base64
     * para incrustarla directamente. En caso de error de conexión o API, 
     * devuelve un objeto con datos y recursos gráficos por defecto.
     *
     * @param string $sFecha Fecha de consulta en formato 'YYYY-MM-DD'.
     * @return FotoNasa Objeto instanciado con los datos astronómicos o con los de fallback en caso de error.
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
     * Descarga y serializa un archivo de imagen en una cadena codificada Base64.
     * * Es una función auxiliar privada. Obtiene el tipo MIME original de la imagen 
     * y genera una cadena lista para ser insertada en el atributo "src" de la etiqueta <img>.
     *
     * @param string $sUrl Enlace directo y público a la imagen a descargar.
     * @return string|null Devuelve la cadena (ej. data:image/jpeg;base64,iVBORw0KG...) o null si falla.
     */
    private static function descargarImagenBase64($sUrl) {
        if (empty($sUrl))
            return null;

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
     * Consulta la API pública de Wikipedia para extraer efemérides históricas.
     * * Solicita los eventos ("On this day") que sucedieron en el mes y día especificados.
     * Extrae de forma aleatoria uno de los múltiples eventos devueltos para añadir variedad.
     *
     * @param string $sMes Mes numérico con formato de dos dígitos (ej. '02').
     * @param string $sDia Día numérico con formato de dos dígitos (ej. '17').
     * @return EventoHistorico Objeto con la información del evento, o un objeto predeterminado de error.
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

    /**
     * Consume la API REST interna para consultar el volumen de facturación.
     * * Envía una solicitud GET segura inyectando la clave autorizada (API_KEY_PROPIA)
     * a través de los Custom HTTP Headers (x-api-key) para evitar la exposición en la URL.
     *
     * @param string $codDepartamento Código identificador único del departamento.
     * @return float|null Devuelve la cifra monetaria en formato float, o null si la autorización falla o no existe.
     */
    public static function apiVolumenNegocioDepartamento($codDepartamento) {
        // url de nuestro servidor
        $sUrl = "http://192.168.1.131/ENLDWESAplicacionFinal/api/wsConsultarVolumenDeNegocio.php?codDepartamento=" . urlencode($codDepartamento);

        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_URL, $sUrl);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 5);

        // Enviamos la clave de forma segura a través de las cabeceras HTTP
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, [
            'x-api-key: ' . API_KEY_PROPIA
        ]);

        $sResultado = curl_exec($oCurl);
        $iHttpCode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        curl_close($oCurl);

        if ($sResultado && $iHttpCode === 200) {
            $aRespuestaApi = json_decode($sResultado, true);

            // Si la API nos devuelve el volumen
            if (isset($aRespuestaApi['volumenDeNegocio'])) {
                return $aRespuestaApi['volumenDeNegocio'];
            }
        }

        return null; // Si hay error en la clave o el departamento no existe
    }
}

?>