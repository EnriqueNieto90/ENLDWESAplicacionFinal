<?php
/**
 * Clase que gestiona la conexión a la base de datos utilizando PDO.
 * * Proporciona métodos estáticos para ejecutar consultas simples y transacciones
 * múltiples, manejando las conexiones de forma segura y capturando los errores 
 * mediante la redirección a una vista de error unificada.
 *
 * @author Enrique Nieto Lorenzo
 * @since 18/01/2026
 * @version 1.1
 */
class DBPDO {
    
    /**
     * Ejecuta una consulta SQL preparada en la base de datos.
     * * Establece una conexión PDO, prepara la sentencia SQL proporcionada y la ejecuta
     * con los parámetros indicados. En caso de error (PDOException), captura la excepción,
     * guarda los datos del error en una variable de sesión utilizando la clase ErrorApp
     * y redirige la ejecución al index para cargar la vista de error.
     *
     * @param string     $sentenciaSQL Instrucción SQL a ejecutar (puede contener marcadores nombrados).
     * @param array|null $parametros   Array asociativo con los valores para vincular a la sentencia SQL.
     * * @return PDOStatement Devuelve el objeto con los resultados de la consulta si tuvo éxito.
     */
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
                $exception->getLine()       // Línea
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
     * * Inicia una transacción PDO, ejecuta un bucle iterando sobre la colección de parámetros
     * y finaliza con un commit. Si cualquier ejecución falla, realiza un rollBack automático
     * para mantener la integridad referencial de la base de datos.
     * * @param string $sentenciaSQL         Instrucción SQL preparada (ej. INSERT INTO...).
     * @param array  $aColeccionParametros Array bidimensional donde cada elemento es un array de parámetros para ejecutar.
     * * @return boolean True si la transacción se completó y guardó con éxito.
     * @throws PDOException Lanza la excepción hacia la capa del modelo si la consulta falla (ej. clave duplicada).
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
            // Cerramos conexión
            unset($oDB);
        }
    }
}
?>