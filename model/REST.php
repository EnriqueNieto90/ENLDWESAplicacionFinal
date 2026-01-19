<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Clase REST para la gestión de la conexión con un Web Service a través de una API REST.
 */

class REST {
    
    const API_KEY_NASA = null;

    public static function apiNasa($fecha){
        //Obtenemos el resultado del servidor de la API REST
        $resultado = file_get_contents($url = "https://api.nasa.gov/planetary/apod?api_key=" . self::API_KEY_NASA);
        
        //Devolvemos el array devuelto por json_decode
        $archivoApi=json_decode($resultado,true);
        //si el archivo se a descodificado correctamente, rotorna la foto
        if(isset($archivoApi)){
             $fotoNasa= new FotoNasa($archivoApi['title'],$archivoApi['url'], $archivoApi['date']);
             return $fotoNasa;
        }
    }
}
?>