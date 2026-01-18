<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 15/12/2025
 * @description: Clase DBPDO para la gestión de la conexión a la base de datos.
 */

class DBPDO {
    
    /**
     * Ejecuta una consulta SQL preparada.
     * * @param string $sentenciaSQL La consulta SQL a preparar.
     * @param array $parametros Los parámetros para la consulta.
     * @return PDOStatement|null El objeto PDOStatement con los resultados o null si falla.
     */
    public static function ejecutarConsulta($sentenciaSQL, $parametros = null) {
        try {
            $miDB = new PDO(DSN, USERNAME, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $consulta = $miDB->prepare($sentenciaSQL);
            $consulta->execute($parametros);
            
            return $consulta;
        } catch (PDOException $exception) {
            echo $exception->getMessage(); 
            return null;
        } finally {
            unset($miDB);
        }
    }
}
?>
