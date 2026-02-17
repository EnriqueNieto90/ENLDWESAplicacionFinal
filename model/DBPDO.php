<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Clase DBPDO para la gestión de la conexión a la base de datos.
 */

class DBPDO {
    
    public static function ejecutarConsulta($sentenciaSQL, $parametros = null) {
        try {
            $miDB = new PDO(DSN, USERNAME, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $consulta = $miDB->prepare($sentenciaSQL);
            $consulta->execute($parametros);
            
            return $consulta;

        } catch (PDOException $exception) {
            session_start();
            
            $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'] ?? 'inicioPublico';
            
            $_SESSION['error'] = new ErrorApp(
                $exception->getCode(),      // Código SQL
                $exception->getMessage(),   // Mensaje técnico
                $exception->getFile(),      // Archivo donde ocurrió
                $exception->getLine(),      // Línea
            );
            
            $_SESSION['paginaEnCurso'] = 'error';
            
            // Redirigimos directamente a index
            header('Location: index.php');
            exit;
        } finally {
            unset($miDB);
        }
    }
    
    /**
     * Ejecuta una misma consulta SQL múltiples veces bajo una sola Transacción.
     * Si una sola ejecución falla, se cancelan todas las demás (Rollback).
     * * @param string $sentenciaSQL La instrucción SQL (ej. INSERT INTO...).
     * @param array $aColeccionParametros Array bidimensional donde cada elemento es un array de parámetros.
     * @return boolean True si la transacción se completó con éxito.
     * @throws PDOException Si hay un error de SQL, lo lanza para ser capturado en el modelo.
     */
    public static function ejecutarTransaccion($sentenciaSQL, $aColeccionParametros) {
        try {
            // Abrimos conexión
            $oDB = new PDO(DSN, USERNAME, PASSWORD);
            $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Iniciamos la transacción
            $oDB->beginTransaction();
            
            // Preparamos la consulta una sola vez
            $oSentencia = $oDB->prepare($sentenciaSQL);
            
            // Ejecutamos la consulta por cada fila de datos
            foreach ($aColeccionParametros as $aParametrosFila) {
                $oSentencia->execute($aParametrosFila);
            }
            
            // Confirmamos los cambios en la BD
            $oDB->commit();
            
            return true;

        } catch (PDOException $oException) {
            // Deshacemos todo en caso de error
            if (isset($oDB) && $oDB->inTransaction()) {
                $oDB->rollBack();
            }
            
            // Lanzamos la excepción hacia arriba
            throw $oException;
            
        } finally {
            unset($oDB);
        }
    }
}
?>